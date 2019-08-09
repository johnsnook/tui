<?php

/**
 * @link http://www.tuiframework.com/
 * @copyright Copyright (c) 2008 Tui Software LLC
 * @license http://www.tuiframework.com/license/
 */
require __DIR__ . '/BaseTui.php';

/**
 * Tui is a helper class serving common framework functionalities.
 *
 * It extends from [[\tui\BaseTui]] which provides the actual implementation.
 * By writing your own Tui class, you can customize some functionalities of [[\tui\BaseTui]].
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Yii extends \tui\BaseTui {

}

spl_autoload_register(['Tui', 'autoload'], true, true);
Tui::$classMap = require __DIR__ . '/classes.php';
Tui::$container = new tui\di\Container();
