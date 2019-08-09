<?php

/**
 * @author John Snook
 * @date May 13, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 * Description of Rectangle
 */

namespace tui\helpers;

class Rectangle {

	public $left, $top, $width, $height;

	/**
	 *
	 * @param integer $top
	 * @param integer $left
	 * @param integer $height
	 * @param integer $width
	 */
	public function __construct($top = 1, $left = 1, $height = 10, $width = 10) {
		$this->left = $left;
		$this->top = $top;
		$this->width = $width;
		$this->height = $height;
	}

	public function __toString() {
		return json_encode(['top' => $this->top, 'left' => $this->left, 'height' => $this->height, 'width' => $this->width], JSON_NUMERIC_CHECK + JSON_UNESCAPED_SLASHES + JSON_UNESCAPED_UNICODE);
	}

	/**
	 *
	 * @param \\tui\helpers\Point $p
	 * @return boolean
	 */
	public function pointInMe(Point $p) {
		return ( $p->top >= $this->top && $p->top <= $this->top + $this->height - 1) &&
				( $p->left >= $this->left && $p->left <= $this->left + $this->width - 1 );
	}

}
