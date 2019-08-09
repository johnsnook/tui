<?php

/**
 * @author John Snook
 * @date May 14, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace tui\helpers;

use tui\base\UnknownPropertyException;

/**
 * A simple object with an width, Height for dimensions
 * @property integer $width The width dimension
 * @property integer $height The Height dimension
 */
class Dimensions {

    const NOT_SET = -1;

    /**
     * @var integer The Width dimension
     */
    public $width = self::NOT_SET;

    /**
     * @var integer The Height dimension
     */
    public $height = self::NOT_SET;

    public function __construct($width = self::NOT_SET, $height = self::NOT_SET) {
        $this->width = $width;
        $this->height = $height;
    }

    public function __toString() {
        return "width: {$this->width}, height: {$this->height}";
    }

    public function normalize() {
        if ($this->width === self::NOT_SET) {
            $this->width = 1;
        }
        if ($this->height === self::NOT_SET) {
            $this->height = 1;
        }
    }

}
