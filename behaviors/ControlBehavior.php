<?php

/**
 * @author John Snook
 * @date May 27, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace tui\behaviors;

class ControlBehavior extends \tui\base\Behavior {

    /**
     * @var boolean Can this element receive focus via arrow keys or tabbing?
     */
    protected $canReceiveFocus = true;

    public function getCanReceiveFocus() {
        return $this->canReceiveFocus;
    }

    public function onFocus() {

    }

    public function onBlur() {

    }

}
