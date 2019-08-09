<?php

/**
 * @author John Snook
 * @date Apr 28, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace tui\helpers;

/**
 * Provides basic interface for a rectangle
 */
interface RectangleInterface {

    /**
     * Getter for the top of the rectangle
     */
    public function getY();

    /**
     * Setter for the top of the rectangle
     */
    public function setTop($val);

    /**
     * Getter for the left of the rectangle
     */
    public function getX();

    /**
     * setter for the left of the rectangle
     */
    public function setLeft($val);

    /**
     * Change the top & left of this rectangle
     */
    public function move($x, $y);

    /**
     * Getter for the height of the rectangle
     */
    public function getHeight();

    /**
     * Setter for the height of the rectangle
     */
    public function setHeight($val);

    /**
     * Getter for the width of the rectangle
     */
    public function getWidth();

    /**
     * Getter for the width of the rectangle
     */
    public function setWidth($val);

    /**
     * Setter for the width of the rectangle
     */
    public function resize($height, $width);

    public function getRectangle();
}
