<?php

/**
 * @author John Snook
 * @date May 12, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace tui\elements;

use \tui\elements\Element;

/**
 * Base class for "active" controls when can be interacted with.
 *
 * This class has the ability to use a shortcut key.  If a label has an
 * underscore before a letter, then that letter becomes the shortcut keys letter.
 * So we need find the position of the underscore, remove it, and highlight
 * the character by adding an underline
 *
 * {@inheritDoc }
 */
class Control extends Element {

    /**
     * @var string $pLabel The buttons label
     */
    protected $pLabel;

    /**
     * @var boolean Can this element receive focus via arrow keys or tabbing?
     */
    protected $pCanReceiveFocus = true;

    public function setLabel($val) {
        $this->pLabel = $val;
    }

    /**
     * the plaintext length of this label
     */
    protected function getLabelLength() {
        return strlen(str_replace('_', '', $this->pLabel));
    }

    public function getLabel() {
        return $this->pLabel;
    }

    public function getCanReceiveFocus() {
        return $this->pCanReceiveFocus;
    }

    public function onFocus() {

    }

    public function onBlur() {

    }

}
