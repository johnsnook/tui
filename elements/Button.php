<?php

/**
 * @author John Snook
 * @date Apr 28, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace tui\elements;

use \tui\components\Style;
use \tui\helpers\Format;
use \tui\behaviors\ClickableBehavior;
use \tui\elements\Element;

/**
 * A button that can be activated via mouse clicks or a shortcut key
 */
class Button extends Element {

    /**
     * @var string $label The buttons label
     */
    protected $label;

    public function setLabel($val) {
        $this->label = $val;
    }

    public function getLabel() {
        return $this->label;
    }

    /**
     * the plaintext length of this label
     */
    protected function getLabelLength() {
        return strlen(str_replace('_', '', $this->label));
    }

    /**
     * {@inheritDoc}
     */
    public function init() {
        parent::init();
        $this->shortcutKeyDecorator = $this->style->getPen(Format::xtermFgColor(255), $this->style->bgColor);
    }

    public function behaviors() {
        #parent::behaviors();
        return [
            'clickable' => ClickableBehavior::className()
        ];
    }

    public function beforeShow() {
        \tui\helpers\Debug::log($this, [
            'rect' => $this->absoluteRectangle,
            'style' => $this->style,
        ]);
        if (parent::beforeShow()) {
            $this->bufferLabel();
            return true;
        }
        return false;
    }

    public function show($forceVisible = false) {
        parent::show($forceVisible);
    }

    /**
     * {@inheritDoc}
     * if we have a border, make it look pushed in.
     */
    public function onMouseDown($event) {
        if ($this->style->borderWidth && $this->style->borderWidth !== Style::NONE) {
            $this->style->borderStyle = Style::INSET;
        } else {
            $this->style->decoration = Format::NEGATIVE;
        }
        $this->buffer->build();
        $this->bufferLabel();
        $this->draw();
    }

    /**
     * {@inheritDoc}
     * if we have a border, set it back to how it was
     */
    public function onMouseUp($event) {
        $this->style->decoration = Format::NORMAL;
        if ($this->style->borderWidth) {
            $this->style->borderStyle = Style::OUTSET;
        }
        $this->buffer->build();
        $this->bufferLabel();
        $this->draw();
    }

    /**
     * This class has the ability to use a shortcut key.  If a label has an
     * underscore before a letter, then that letter becomes the shortcut keys letter.
     * So we need find the position of the underscore, remove it, and highlight
     * the character by adding an underline
     *
     * Welcome the 3rd edition of "prepareLabel".  Takes a string with or without
     * an underscore and writes it to the center of the buffer.  At some point
     * I should add text justification to the Style.  Maybe a $labelRect?
     */
    public function bufferLabel() {
//        if (empty($this->label)) {
//            return;
//        }
        if ($this->style->textAlign === Style::CENTER) {
            $y = round(($this->height > 2) ? ($this->height / 2) : 1);
            $x = round(($this->width / 2) - ($this->labelLength / 2));
        } else {
            $y = 1 + $this->style->paddingTop;
            $x = 1 + $this->style->paddingLeft;
        }

        $label = str_replace('_', '', $this->label);
        $this->buffer->writeToRow($label, $y - 1, $x - 1);

        if (($shortcutPos = strpos($this->label, '_')) !== false) {
            $letter = substr($label, $shortcutPos, 1);
            $this->shortcutKey = strtolower($letter);
            $this->buffer->code($y - 1, $x + $shortcutPos - 1, $this->shortcutKeyDecorator);
        } else {
            $this->shortcutKey = null;
        }
    }

}
