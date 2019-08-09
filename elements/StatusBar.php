<?php

/**
 * @author John Snook
 * @date April 28, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace tui\elements;

use \tui\elements\Element;

/**
 * Represents a line at the bottom of the screen upon which status or help can
 * be displayed
 */
class StatusBar extends Element {

	public $text;

	public function beforeShow() {
		if (parent::beforeShow()) {
			$this->changeText($this->text);
			return true;
		}
		return false;
	}

	public function changeText($text) {
		$length = strlen($text);
		$oldLength = strlen($this->text);
		$this->text = $text;
		if ($length <= $oldLength) {
			$text = str_pad($text, $oldLength);
		}
		$this->buffer->writeToRow($text, 0, $this->style->paddingLeft);
		$this->draw();
	}

}
