<?php

/**
 * @author John Snook
 * @date May 8, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */
/**
 * @link http://www.tuiframework.com/
 * @copyright Copyright (c) 2008 Tui Software LLC
 * @license http://www.tuiframework.com/license/
 */
//namespace tui;
//require __DIR__ . '/BaseTui.php';

/**
 * Static class to provide services to all objects in the Tui app.
 */
class Tui extends \tui\base\BaseTui {

}

Tui::$container = new tui\di\Container();
Tui::$observer = tui\components\Observer::getInstance();
Tui::$styleSheet = require 'css.php';
