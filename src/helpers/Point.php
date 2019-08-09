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
 * A simple object with an LEFT,TOP for coordinates
 * @property integer $left The LEFT coordinate
 * @property integer $top The TOP coordinate
 */
class Point {

    const NOT_SET = -1;

    /**
     * @var integer The LEFT coordinate
     */
    public $left = self::NOT_SET;

    /**
     * @var integer The TOP coordinate
     */
    public $top = self::NOT_SET;

    /**
     *
     * @param integer $left The column coordinate
     * @param integer $top The row coordinate
     * @throws \UnexpectedValueException Better pass in integers
     */
    public function __construct($left = self::NOT_SET, $top = self::NOT_SET) {
        if (!is_numeric($left)) {
            throw new \UnexpectedValueException("Point::left must be numeric, '$left' given.");
        }
        if (!is_numeric($top)) {
            throw new \UnexpectedValueException("Point::top must be numeric, '$top' given.");
        }
        $this->left = (int) $left;
        $this->top = (int) $top;
    }

    public function __toString() {
        return "left: {$this->left}, top: {$this->top}";
    }

    public function normalize() {
        if ($this->left === self::NOT_SET) {
            $this->left = 1;
        }
        if ($this->top === self::NOT_SET) {
            $this->top = 1;
        }
    }

}
