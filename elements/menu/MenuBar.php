<?php

/**
 * @author John Snook
 * @date April 28, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace tui\elements\menu;

use \tui\elements\Container;
use \tui\components\Style;

/**
 * {@inheritDoc}
 * Represents the menu bar, contains MenuBarElements
 */
class MenuBar extends Container {
//	public function init() {
//		//$this->css['align'] = Style::TOP;
//		parent::init();
//		\\tui\helpers\Debug::log($this, [$this->absoluteRectangle, $this->style->css]);
//	}

	/**
	 * {@inheritDoc}
	 * Position the menu items
	 */
	public function beforeShow() {
		if (parent::beforeShow()) {
			$pos = $this->left + 2;
			foreach ($this->elements as $element) {
				$length = $element->width;
				$element->move(1, $pos);
				$pos = $pos + $length + 1;
			}
			#\\tui\helpers\Debug::log($this);
			return TRUE;
		}
		return FALSE;
	}

}
