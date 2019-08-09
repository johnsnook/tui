<?php

/**
 * @author John Snook
 * @date May 12, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace tui\elements;

use \tui\elements\Element;
use \tui\components\Style;

/**
 * Text container
 */
class Label extends Element {

    /**
     * @var string To use, a KeyPressEvent::description string
     *
     */
    public $pShortcutKey;

    /**
     * @var string this should contain a \\tui\components\Style Pen string.
     */
    public $shortcutKeyDecorator;

    /**
     * @var string this should contain a \\tui\components\Style Pen string.
     */
    public $pen;

    /**
     * @var string The character to use to pad the label.  Most times you'll
     * want it to be space, but for a title bar you might want to use a unicode
     * character.
     */
    public $padCharacter = ' ';

    /**
     * The labels text
     */
    private $pText = 'Label';

    public function setText($val) {
        $this->pText = $val;
    }

    public function getText() {
        return $this->pText;
    }

    /**
     * the plaintext length of this label
     */
    protected function getLabelLength() {
        return mb_strlen(str_replace('_', '', $this->pText));
    }

    /**
     *
     * @return string The shortcut key detected in the label by bufferLabel
     */
    public function getShortcutKey() {
        return $this->pShortcutKey;
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
    public function prepare($buffer) {
        $label = $this->pText;
        switch ($this->style->textAlign) {
            case Style::LEFT:
                $label = Unicodes::mbStringPad($this->pText, $this->width, $this->padCharacter, STR_PAD_BOTH);
                break;
            case Style::CENTER:
                $label = Unicodes::mbStringPad($this->pText, $this->width, $this->padCharacter, STR_PAD_BOTH);
                break;
            case Style::CENTER:
                $label = Unicodes::mbStringPad($this->pText, $this->width, $this->padCharacter, STR_PAD_BOTH);
                break;
        }

        if ($this->style->textAlign === Style::CENTER) {
            $y = round(($this->height > 2) ? ($this->height / 2) : 1);
            $x = round(($this->width / 2) - ($this->labelLength / 2));
        } else {
            $y = 1 + $this->style->paddingTop;
            $x = 1 + $this->style->paddingLeft;
        }

        $label = str_replace('_', '', $this->pText);
        $buffer->writeToRow($label, $y - 1, $x - 1);

        if (($shortcutPos = strpos($this->pText, '_')) !== false) {
            $letter = substr($label, $shortcutPos, 1);
            $this->shortcutKey = strtolower($letter);
            $buffer->code($y - 1, $x + $shortcutPos - 1, $this->shortcutKeyDecorator);
        }
    }

}
