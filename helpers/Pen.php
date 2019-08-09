<?php

/**
 * @author John Snook
 * @date May 24, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 * Description of Pen
 */

namespace tui\helpers;

class Pen {

    public $fgColor;
    public $bgColor;
    public $decoration;

    public function __construct($fgColor, $bgColor, $decoration = null) {
        $this->fgColor = $fgColor;
        $this->bgColor = $bgColor;

        if ($decoration) {
            $this->decoration = $decoration;
        }
    }

    //
    public function code() {
        $return = "\e[{$this->fgColor};{$this->bgColor}";
        if ($this->decoration) {
            $return .= $this->decoration;
        }
        return $return .= 'm';
    }

}
