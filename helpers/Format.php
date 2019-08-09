<?php

/**
 * @link http://www.tuiframework.com/
 * @copyright Copyright (c) 2008 Tui Software LLC
 * @license http://www.tuiframework.com/license/
 */
/**
 * @author John Snook
 * @date Apr 29, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 * @see https://en.wikipedia.org/wiki/ANSI_escape_code#CSI_codes
 */

namespace tui\helpers;

use tui\helpers\Console;

class Format {

    const ESC = "\033[";
    //const ESC = "\x1b[";
    // foreground color control codes
    const FG_BLACK = 30;
    const FG_RED = 31;
    const FG_GREEN = 32;
    const FG_YELLOW = 33;
    const FG_BLUE = 34;
    const FG_PURPLE = 35;
    const FG_CYAN = 36;
    const FG_GREY = 37;
    // background color control codes
    const BG_BLACK = 40;
    const BG_RED = 41;
    const BG_GREEN = 42;
    const BG_YELLOW = 43;
    const BG_BLUE = 44;
    const BG_PURPLE = 45;
    const BG_CYAN = 46;
    const BG_GREY = 47;
    // fonts style control codes
    const END_ANSI = self::ESC . '0m';
    const RESET = 0;
    const NORMAL = 0;
    const BOLD = 1;
    const ITALIC = 3;
    const UNDERLINE = 4;
    const BLINK = 5;
    const NEGATIVE = 7;
    const CONCEALED = 8;
    const CROSSED_OUT = 9;
    const FRAMED = 51;
    const ENCIRCLED = 52;
    const OVERLINED = 53;

    /**
     * Returns the ANSI format code.
     *
     * @param array $format An array containing formatting values.
     * You can pass any of the `FG_*`, `BG_*` and `TEXT_*` constants
     * and also [[xtermFgColor]] and [[xtermBgColor]] to specify a format.
     * @return string The ANSI format code according to the given formatting constants.
     */
    public static function ansiCode($format) {
        return static::ESC . implode(';', $format) . 'm';
    }

    /**
     * Echoes an ANSI format code that affects the formatting of any text that is printed afterwards.
     *
     * @param array $format An array containing formatting values.
     * You can pass any of the `FG_*`, `BG_*` and `TEXT_*` constants
     * and also [[xtermFgColor]] and [[xtermBgColor]] to specify a format.
     * @see ansiFormatCode()
     * @see endAnsiFormat()
     */
    public static function beginAnsi($format) {
        echo static::ESC . implode(';', $format) . 'm';
    }

    /**
     * Resets any ANSI format set by previous method [[beginAnsiFormat()]]
     * Any output after this will have default text format.
     * This is equal to calling.
     *
     * ```php
     * echo Console::ansiFormatCode([Console::RESET])
     * ```
     */
    public static function endAnsi() {
        echo static::ESC . "0m";
    }

    /**
     * Will return a string formatted with the given ANSI style.
     *
     * @param string $string the string to be formatted
     * @param array $format An array containing formatting values.
     * You can pass any of the `FG_*`, `BG_*` and `TEXT_*` constants
     * and also [[xtermFgColor]] and [[xtermBgColor]] to specify a format.
     * @return string
     */
    public static function ansi($string, $format = []) {
        $code = implode(';', $format);

        return static::ESC . "0m" . ($code !== '' ? static::ESC . $code . 'm' : '') . $string . static::ESC . "0m";
    }

    /**
     * Returns the ansi format code for xterm foreground color.
     *
     * You can pass the return value of this to one of the formatting methods:
     * [[ansiFormat]], [[ansiFormatCode]], [[beginAnsiFormat]].
     *
     * @param int $colorCode xterm color code
     * @return string
     * @see http://en.wikipedia.org/wiki/Talk:ANSI_escape_code#xterm-256colors
     */
    public static function xtermFgColor($colorCode) {
        return '38;5;' . $colorCode;
    }

    /**
     * Returns the ansi format code for xterm background color.
     *
     * You can pass the return value of this to one of the formatting methods:
     * [[ansiFormat]], [[ansiFormatCode]], [[beginAnsiFormat]].
     *
     * @param int $colorCode xterm color code
     * @return string
     * @see http://en.wikipedia.org/wiki/Talk:ANSI_escape_code#xterm-256colors
     */
    public static function xtermBgColor($colorCode) {
        return '48;5;' . $colorCode;
    }

    /**
     * Strips ANSI control codes from a string.
     *
     * @param string $string String to strip
     * @return string
     */
    public static function stripAnsi($string) {
        return preg_replace('/\033\[[\d;?]*\w/', '', $string);
    }

    /**
     * Returns the length of the string without ANSI color codes.
     * @param string $string the string to measure
     * @return int the length of the string not counting ANSI format characters
     */
    public static function ansiStrlen($string) {
        return mb_strlen(static::stripAnsi($string));
    }

    /**
     * Converts a string to ansi formatted by replacing patterns like %y (for yellow) with ansi control codes.
     *
     * Uses almost the same syntax as https://github.com/pear/Console_Color2/blob/master/Console/Color2.php
     * The conversion table is: ('bold' meaning 'light' on some
     * terminals). It's almost the same conversion table irssi uses.
     * <pre>
     *                  text      text            background
     *      ------------------------------------------------
     *      %k %K %0    black     dark grey       black
     *      %r %R %1    red       bold red        red
     *      %g %G %2    green     bold green      green
     *      %y %Y %3    yellow    bold yellow     yellow
     *      %b %B %4    blue      bold blue       blue
     *      %m %M %5    magenta   bold magenta    magenta
     *      %p %P       magenta (think: purple)
     *      %c %C %6    cyan      bold cyan       cyan
     *      %w %W %7    white     bold white      white
     *
     *      %F     Blinking, Flashing
     *      %U     Underline
     *      %8     Reverse
     *      %_,%9  Bold
     *
     *      %n     Resets the color
     *      %%     A single %
     * </pre>
     * First param is the string to convert, second is an optional flag if
     * colors should be used. It defaults to true, if set to false, the
     * color codes will just be removed (And %% will be transformed into %)
     *
     * @param string $string String to convert
     * @param bool $colored Should the string be colored?
     * @return string
     */
    public static function renderColoredString($string, $colored = true) {
        // TODO rework/refactor according to https://github.com/tuisoft/tui/issues/746
        static $conversions = [
            '%y' => [self::FG_YELLOW],
            '%g' => [self::FG_GREEN],
            '%b' => [self::FG_BLUE],
            '%r' => [self::FG_RED],
            '%p' => [self::FG_PURPLE],
            '%m' => [self::FG_PURPLE],
            '%c' => [self::FG_CYAN],
            '%w' => [self::FG_GREY],
            '%k' => [self::FG_BLACK],
            '%n' => [0], // reset
            '%Y' => [self::FG_YELLOW, self::BOLD],
            '%G' => [self::FG_GREEN, self::BOLD],
            '%B' => [self::FG_BLUE, self::BOLD],
            '%R' => [self::FG_RED, self::BOLD],
            '%P' => [self::FG_PURPLE, self::BOLD],
            '%M' => [self::FG_PURPLE, self::BOLD],
            '%C' => [self::FG_CYAN, self::BOLD],
            '%W' => [self::FG_GREY, self::BOLD],
            '%K' => [self::FG_BLACK, self::BOLD],
            '%N' => [0, self::BOLD],
            '%3' => [self::BG_YELLOW],
            '%2' => [self::BG_GREEN],
            '%4' => [self::BG_BLUE],
            '%1' => [self::BG_RED],
            '%5' => [self::BG_PURPLE],
            '%6' => [self::BG_CYAN],
            '%7' => [self::BG_GREY],
            '%0' => [self::BG_BLACK],
            '%F' => [self::BLINK],
            '%U' => [self::UNDERLINE],
            '%8' => [self::NEGATIVE],
            '%9' => [self::BOLD],
            '%_' => [self::BOLD],
        ];

        if ($colored) {
            $string = str_replace('%%', '% ', $string);
            foreach ($conversions as $key => $value) {
                $string = str_replace(
                        $key, static::ansiCode($value), $string
                );
            }
            $string = str_replace('% ', '%', $string);
        } else {
            $string = preg_replace('/%((%)|.)/', '$2', $string);
        }

        return $string;
    }

    /**
     * Escapes % so they don't get interpreted as color codes when
     * the string is parsed by [[renderColoredString]].
     *
     * @param string $string String to escape
     *
     * @return string
     */
    public static function escape($string) {
        // TODO rework/refactor according to https://github.com/tuisoft/tui/issues/746
        return str_replace('%', '%%', $string);
    }

    /**
     * Returns true if the stream supports colorization. ANSI colors are disabled if not supported by the stream.
     *
     * - windows without ansicon
     * - not tty consoles
     *
     * @param mixed $stream
     * @return bool true if the stream supports ANSI colors, otherwise false.
     */
    public static function streamSupportsAnsiColors($stream) {
        return DIRECTORY_SEPARATOR === '\\' ? getenv('ANSICON') !== false || getenv('ConEmuANSI') === 'ON' : function_exists('posix_isatty') && @posix_isatty($stream);
    }

}
