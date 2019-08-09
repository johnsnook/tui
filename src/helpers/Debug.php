<?php

/**
 * @author John Snook
 * @date May 8, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 * Description of DebugTrait
 */

namespace tui\helpers;

use \tui\elements\Element;
use \tui\helpers\Screen;

class Debug {

    const LOG_FILE = __DIR__ . '/../log/tui.log';
    const EOT = 'EOT';
    const BACKTRACE = 'backtrace';

    public static function log($object, $data = null) {

        $out = [];
        if ($data === self::EOT) {
            file_put_contents(self::LOG_FILE, str_repeat('═', Screen::$width) . PHP_EOL, FILE_APPEND);
            return;
        }
        static $i = 0;
        $class = explode('\\', get_class($object));
        $class = $class[count($class) - 1];
        if ($object instanceof Element) {
            $out[] = str_pad($class . "#{$object->id}[{$object->counter}]: " . $i++, 25);
        } else {
            $out[] = str_pad($class, 25);
        }

        $baseClass = explode('\\', debug_backtrace()[1]['class']);
        $out[] = self::getCaller() . '=>' . $baseClass[2] . '->' . debug_backtrace()[1]['function'] . '(' . implode(',', debug_backtrace()[1]['args']) . ')';

        file_put_contents(self::LOG_FILE, implode("\t", $out) . PHP_EOL, FILE_APPEND);
        if ($data === true) {
            file_put_contents(self::LOG_FILE, self::generateCallTrace() . PHP_EOL, FILE_APPEND);
        } elseif ($data === self::BACKTRACE) {
            $backtrace = debug_backtrace();
            $data = json_encode($backtrace, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
            file_put_contents(self::LOG_FILE, $data . PHP_EOL, FILE_APPEND);
        } elseif (!is_null($data)) {
            if (is_array($data) || is_object($data)) {
                $data = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
            }
            file_put_contents(self::LOG_FILE, $data . PHP_EOL, FILE_APPEND);
        }
    }

    private static function generateCallTrace($includeFileInfo = false) {
        $e = new \Exception();
        $trace = $e->getTrace();
        // reverse array to make steps line up chronologically
        $trace = array_reverse($trace);
        array_shift($trace); // remove {main}
        array_pop($trace); // remove call to this method
        array_pop($trace); // remove call to this method

        if ($includeFileInfo) {
            return $trace;
        } else {
            $result = [];
            $i = 1;
            foreach ($trace as $line) {
                if (key_exists('class', $line) && strpos($line['class'], 'tui')) {
                    $class = array_pop(explode('\\', $line['class']));
                    $args = $line['args'];
                    array_shift($args);
                    $args = implode(',', $args);
                    $result[] = $i++ . "\t{$class}{$line['type']}{$line['function']}({$args})";
                }
            }
            return implode("\n", $result);
        }
    }

    private static function getCaller() {
        $e = new \Exception();
        $trace = explode("\n", $e->getTraceAsString());
        // reverse array to make steps line up chronologically
        array_shift($trace); // remove {main}
        array_pop($trace); // remove call to this method
        $caller = explode('\\', $trace[1]);
        $caller = $caller[count($caller) - 1];
        return $caller; // replace '#someNum' with '$i)', set the right ordering
    }

    private static function generateCallTraceString() {
        $e = new \Exception();
        $trace = explode("\n", $e->getTraceAsString());
        // reverse array to make steps line up chronologically
        $trace = array_reverse($trace);
        array_shift($trace); // remove {main}
        array_pop($trace); // remove call to this method
        $length = count($trace);
        $result = array();

        for ($i = 0; $i < $length; $i++) {
            $result[] = ($i + 1) . ')' . substr($trace[$i], strpos($trace[$i], ' ')); // replace '#someNum' with '$i)', set the right ordering
        }

        return implode("\n", $result);
    }

}
