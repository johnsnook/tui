<?php

/**
 * @author John Snook
 * @date May 3, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace tui\components;

use \tui\elements\Element;
use \tui\helpers\Rectangle;
use \tui\components\Style;
use \tui\helpers\Border;
use \tui\helpers\Format;
use \tui\helpers\Debug;
use tui\base\Component;

/**
 * Contains the character and and format codes arrays for each "pixel"
 * Both properties are two dimensional arrays
 * @property integer $width
 * @property integer $height
 * @property array $format array of integers representing Format codes
 */
class Buffer extends Component {

    /**
     * @var string[] The characters.  Each array element should be 1 character
     */
    private $character = [];

    /**
     * @var string[] The formatting.  Each array element has the ANSI escape
     * codes for the corresponding character.
     */
    public $code = [];

    /**
     * @var Element The element that invoked this class
     */
    private $owner;

    /**
     * Overrides the Component::init() method.  Ensures that the owner is set
     * @throws \BadMethodCallException
     */
    public function init() {
        if (!isset($this->owner)) {
            throw new \BadMethodCallException("Owner must be set on Buffer creation.");
        }
    }

    /**
     * Get the width of the element
     */
    public function getWidth() {
        return $this->owner->width;
    }

    /**
     * Get the height of the element
     */
    public function getHeight() {
        return $this->owner->height;
    }

    /**
     * @return The owners style
     */
    public function getStyle() {
        return $this->owner->style;
    }

    /**
     * Set the property, attach to Rectangle change events
     * @param Element $val
     */
    public function setOwner(Element $val) {
        $this->owner = $val;
        $this->owner->on(Element::RESIZE_EVENT, [$this, 'handleElementEvent']);
    }

    public function handleElementEvent($event) {
        $this->build();
    }

    /**
     * Builds the buffer
     *
     * Populate the cells of the arrays with spaces and the default format and
     * apply a border if specified by the style object
     */
    public function build() {
        $this->character = [];
        $this->code = [];
        if ($this->height < 1) {
            Debug::log($this->owner);
//            $this->owner->debug([
//                '$subject->position' => $this->owner->position,
//                '$subject->dimensions' => $this->owner->dimensions,
//            ]);
        }

        for ($i = 0; $i < $this->height; $i++) {
            $this->character[$i] = array_fill(0, $this->width, $this->style->bgPattern);
            $this->code[$i] = array_fill(0, $this->width, $this->style->pen);
        }
        if ($this->style->borderWidth && ($this->style->borderWidth !== Style::NONE && $this->height >= 2 && $this->width >= 2)) {
            Border::apply($this);
        }
    }

    /**
     * Converts this object to a string
     * @return string A json string
     */
    public function __toString() {
        return json_encode([
            'height' => $this->height,
            'width' => $this->width,
            'character' => empty($this->character) ? 'empty' : [
        'rows' => count($this->character),
        'cols' => isset($this->character[0]) ? count($this->character[0]) : 'empty'
            ],
            'code' => empty($this->code) ? 'empty' : [
        'rows' => count($this->code),
        'cols' => isset($this->code[0]) ? count($this->code[0]) : 'empty'
            ],
            'hasBorder' => empty($this->style->borderWidth) ? 'No' : 'Yes',
            'format' => $this->style->pen,
        ]);
    }

    /**
     * Gets or puts single character from/to the array
     * @param integer $row
     * @param integer $column
     * @param string $character A single character
     * @return string
     */
    public function character($row, $column, $character = null) {
        /**
         * @todo remove this and punish the offenders
         */
        if ($column >= $this->width) {
            $column = $this->width - 1;
        }
        if (!is_null($character) && strlen($character) === 1) {
            $this->character[$row][$column] = $character;
        }
        try {
            return $this->character[$row][$column];
        } catch (\ErrorException $e) {
            Debug::log($this, $e->getMessage());
            throw $e;
        }
    }

    /**
     * Gets ANSI format code, ready for console
     * @param integer $row
     * @param integer $column
     * @param string $code an ANSI code beginning with ESC
     * @return string
     */
    public function code($row, $column, $code = null) {
        /**
         * @todo remove this and punish the offenders
         */
        if ($column >= $this->width) {
            $column = $this->width - 1;
        }

        if (!is_null($code) && ord($code) === 27) {
            $this->code[$row][$column] = $code;
        }
        try {
            return $this->code[$row][$column];
        } catch (\ErrorException $e) {
            Debug::log($this, $e->getMessage());
            throw $e;
        }
    }

    /**
     * Writes to the buffer horizontally
     *
     * @param string | array $input
     * @param integer $row
     * @param integer $col
     * @param mixed $format
     */
    public function writeToRow($input, $row = 0, $col = 0, $format = null) {
        if (is_array($format)) {
            $format = Format::ansiCode($format);
        }
        if (is_string($input)) {
            $input = preg_split('//u', $input, null, PREG_SPLIT_NO_EMPTY);
            #$input = str_split($input);
        }
        for ($i = 0; $i < count($input); $i++) {
            $this->character[$row][$col + $i] = $input[$i];
            if (!is_null($format)) {
                $this->code[$row][$col + $i] = $format;
            } elseif (!empty($this->style->pen)) {
                $this->code[$row + $i][$col] = $this->style->pen;
            }
        }
        return $this->readAnsiLine($row, $col, count($input));
    }

    /**
     * Writes to the buffer horizontally
     *
     * @param string| array $input
     * @param integer $row
     * @param integer $col
     * @param mixed $format
     */
    public function writeToColumn($input, $row, $col, $format = null) {
        if (is_array($format)) {
            $format = Format::ansiCode($format);
        }
        if (is_string($input)) {
            $input = preg_split('//u', $input, null, PREG_SPLIT_NO_EMPTY);
            #$input = str_split($input);
        }
        for ($i = 0; $i < count($input); $i++) {
            $this->character[$row + $i][$col] = $input[$i];
            if (!is_null($format)) {
                $this->code[$row + $i][$col] = $format;
            } elseif (!empty($this->style->pen)) {
                $this->code[$row + $i][$col] = $this->style->pen;
            }
        }
    }

    /**
     * Returns a section of a buffer row as a string ready to echo
     * @param integer $row
     * @param integer $col
     * @param integer $length
     * @return string
     */
    public function readAnsiLine($row, $col = 0, $length = null) {
        if (empty($length) || (($col + $length) > $this->width)) {
            $length = $this->width - $col;
        }
        $lastCode = $this->code($row, $col);
        $return = $lastCode;
        for ($i = $col; $i < $length + $col; $i++) {
            if (($thisCode = $this->code($row, $i)) !== $lastCode) {
                $return .= Format::END_ANSI . $thisCode;
                $lastCode = $thisCode;
            }
            $return .= $this->character($row, $i);
        }
        return $return . Format::END_ANSI;
    }

    /**
     * Get all lines in the buffer
     * @return array
     */
    public function readAnsiLines($row = 0, $col = 0, $length = null, $height = null) {
        $return = [];
        $height = (is_null($height) ? $this->height : $height + $row);
        for (; $row < $height; $row++) {
            $return[] = $this->readAnsiLine($row, $col, $length);
        }
        return $return;
    }

    /**
     *
     * @param \\tui\helpers\Rectangle $r
     */
    public function readRect(Rectangle $r) {
        $copy = clone($this);
        $copy->character = $copy->code = [];
        $copy->width = $r->width;
        $copy->height = $r->height;
        $newRow = 0;
        for ($row = $r->top; $row < $r->height; $row++) {
            $copy->character[$newRow] = array_slice($this->character, $r->left, $r->width);
            $copy->code[$newRow++] = array_slice($this->code, $r->left, $r->width);
        }
    }

    /**
     * Merge a child buffer object with this one
     *
     * @param \\tui\components\Buffer $child
     * @param integer $top
     * @param integer $y
     */
    public function merge(Buffer $child, $top, $y) {
        for ($childRow = 0; $childRow < count($child->character); $childRow++) {
            for ($childCol = 0; $childCol < count($child->character[$childRow]); $childCol++) {
                $this->character[$top + $childRow][$y + $childCol] = $child->character($childRow, $childCol);
                $this->code[$top + $childRow][$y + $childCol] = $child->code($childRow, $childCol);
            }
        }
    }

}
