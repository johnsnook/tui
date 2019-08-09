<?php
/**
 * @link http://www.tuiframework.com/
 * @copyright Copyright (c) 2008 Tui Software LLC
 * @license http://www.tuiframework.com/license/
 */

namespace tui\base;

/**
 * InvalidArgumentException represents an exception caused by invalid arguments passed to a method.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0.14
 */
class InvalidArgumentException extends InvalidParamException
{
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'Invalid Argument';
    }
}
