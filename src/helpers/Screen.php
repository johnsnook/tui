<?php

/**
 * @author John Snook
 * @date Apr 29, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 * Description of Screen
 */

namespace tui\helpers;

use \tui\helpers\Rectangle;

class Screen {

    const ESC = "\033[";

    public static $height;
    public static $width;

    public static function getScreenRect() {
        list($w, $h) = static::getSize();
        return new Rectangle(1, 1, $h, $w);
    }

    /**
     * Clears entire screen content by sending ANSI control code ED with argument 2 to the terminal.
     * Cursor position will not be changed.
     * **Note:** ANSI.SYS implementation used in windows will reset cursor position to upper left corner of the screen.
     */
    public static function clear() {
        echo static::ESC . "2J";
    }

    /**
     * Clears text from cursor to the beginning of the screen by sending ANSI control code ED with argument 1 to the terminal.
     * Cursor position will not be changed.
     */
    public static function clearBeforeCursor() {
        echo static::ESC . "1J";
    }

    /**
     * Clears text from cursor to the end of the screen by sending ANSI control code ED with argument 0 to the terminal.
     * Cursor position will not be changed.
     */
    public static function clearAfterCursor() {
        echo static::ESC . "0J";
    }

    /**
     * Clears the line, the cursor is currently on by sending ANSI control code EL with argument 2 to the terminal.
     * Cursor position will not be changed.
     */
    public static function clearLine() {
        echo static::ESC . "2K";
    }

    /**
     * Clears text from cursor position to the beginning of the line by sending ANSI control code EL with argument 1 to the terminal.
     * Cursor position will not be changed.
     */
    public static function clearLineBeforeCursor() {
        echo static::ESC . "1K";
    }

    /**
     * Clears text from cursor position to the end of the line by sending ANSI control code EL with argument 0 to the terminal.
     * Cursor position will not be changed.
     */
    public static function clearLineAfterCursor() {
        echo static::ESC . "0K";
    }

    /**
     * Returns terminal screen size.
     *
     * Usage:
     *
     * ```php
     * list($width, $height) = Screen::getSize();
     * ```
     *
     * @param bool $refresh whether to force checking and not re-use cached size value.
     * This is useful to detect changing window size while the application is running but may
     * not get up to date values on every terminal.
     * @return array|bool An array of ($width, $height) or false when it was not able to determine size.
     */
    public static function getSize($refresh = false) {
        static $size;
        if ($size !== null && !$refresh) {
            return $size;
        }

        if (static::isRunningOnWindows()) {
            $output = [];
            exec('mode con', $output);
            if (isset($output, $output[1]) && strpos($output[1], 'CON') !== false) {
                return $size = [
                    self::$width = (int) preg_replace('~\D~', '', $output[4]),
                    self::$height = (int) preg_replace('~\D~', '', $output[3])
                ];
            }
        } else {
            // try stty if available
            $stty = [];
            if (exec('stty -a 2>&1', $stty)) {
                $stty = implode(' ', $stty);

                // Linux stty output
                if (preg_match('/rows\s+(\d+);\s*columns\s+(\d+);/mi', $stty, $matches)) {
                    return $size = [
                        self::$width = (int) $matches[2],
                        self::$height = (int) $matches[1]
                    ];
                }

                // MacOS stty output
                if (preg_match('/(\d+)\s+rows;\s*(\d+)\s+columns;/mi', $stty, $matches)) {
                    return $size = [
                        self::$width = (int) $matches[2],
                        self::$height = (int) $matches[1]
                    ];
                }
            }

            // fallback to tput, which may not be updated on terminal resize
            if (($width = (int) exec('tput cols 2>&1')) > 0 && ($height = (int) exec('tput lines 2>&1')) > 0) {
                return $size = [
                    self::$width = $width,
                    self::$height = $height
                ];
            }

            // fallback to ENV variables, which may not be updated on terminal resize
            if (($width = (int) getenv('COLUMNS')) > 0 && ($height = (int) getenv('LINES')) > 0) {
                return $size = [
                    self::$width = $width,
                    self::$height = $height
                ];
            }
        }

        return $size = false;
    }

    /**
     * Returns true if the console is running on windows.
     * @return bool
     */
    public static function isRunningOnWindows() {
        return DIRECTORY_SEPARATOR === '\\';
    }

}
