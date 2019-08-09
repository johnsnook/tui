<?php

namespace tui\helpers;

/**
 * @link http://www.tuiframework.com/
 * @copyright Copyright (c) 2008 Tui Software LLC
 * @license http://www.tuiframework.com/license/
 *
 * @author John Snook
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */
use \tui\helpers\Screen;

/**
 * Cursor functions plucked from Tui Base Console
 */
class Cursor {

    const ESC = "\033[";

    /**
     * Gets the vertical and horizontal position of the cursor
     *
     * @return array|bool An array of ($vertical, $horizontal) or false when it was not able to determine info.
     */
//    public static function getPosition() {
//        $term = `stty -g`;
//        $term = substr($term, 0, strlen($term) - 1);
//        system("stty -echo");
//
//        echo self::ESC . "6n";
//        $r = explode(';', fread(STDIN, 10));
//        system("stty '" . $this->term . "'");
//
//        $v = str_split($r[0]);
//        $h = str_split($r[1]);
//        $vertical = '';
//        foreach ($h as $b) {
//            if (is_numeric($b)) {
//                $vertical .= $b;
//            }
//        }
//        $horizontal = '';
//        foreach ($v as $b) {
//            if (is_numeric($b)) {
//                $horizontal .= $b;
//            }
//        }
//        return [(int) $vertical, (int) $horizontal];
//    }

    /**
     * Moves the terminal cursor up by sending ANSI control code CUU to the terminal.
     * If the cursor is already at the edge of the screen, this has no effect.
     * @param int $rows number of rows the cursor should be moved up
     */
    public static function up($rows = 1) {
        echo self::ESC . (int) $rows . 'A';
    }

    /**
     * Moves the terminal cursor up by sending ANSI control code CUU to the terminal.
     * If the cursor is already at the edge of the screen, this has no effect.
     * @param int $rows number of rows the cursor should be moved up
     */
    public static function pageUp($rows = null) {
        if (is_null($rows)) {
            $rows = Screen::$height;
        }
        echo self::ESC . (int) $rows . 'S';
    }

    /**
     * Moves the terminal cursor down by sending ANSI control code CUD to the terminal.
     * If the cursor is already at the edge of the screen, this has no effect.
     * @param int $rows number of rows the cursor should be moved down
     */
    public static function down($rows = 1) {
        echo self::ESC . (int) $rows . 'B';
    }

    /**
     * Moves the terminal cursor forward by sending ANSI control code CUF to the terminal.
     * If the cursor is already at the edge of the screen, this has no effect.
     * @param int $steps number of steps the cursor should be moved forward
     */
    public static function forward($steps = 1) {
        echo self::ESC . (int) $steps . 'C';
    }

    /**
     * Moves the terminal cursor backward by sending ANSI control code CUB to the terminal.
     * If the cursor is already at the edge of the screen, this has no effect.
     * @param int $steps number of steps the cursor should be moved backward
     */
    public static function backward($steps = 1) {
        echo self::ESC . (int) $steps . 'D';
    }

    /**
     * Moves the terminal cursor to the beginning of the next line by sending ANSI control code CNL to the terminal.
     * @param int $lines number of lines the cursor should be moved down
     */
    public static function nextLine($lines = 1) {
        echo self::ESC . (int) $lines . 'E';
    }

    /**
     * Moves the terminal cursor to the beginning of the previous line by sending ANSI control code CPL to the terminal.
     * @param int $lines number of lines the cursor should be moved up
     */
    public static function prevLine($lines = 1) {
        echo self::ESC . (int) $lines . 'F';
    }

    /**
     * Moves the cursor to an absolute position given as column and row by sending ANSI control code CUP or CHA to the terminal.
     * @param int $column 1-based column number, 1 is the left edge of the screen.
     * @param int|null $row 1-based row number, 1 is the top edge of the screen. if not set, will move cursor only in current line.
     */
    public static function moveTo($column, $row = null) {
        if ($row === null) {
            echo self::ESC . (int) $column . 'G';
        } else {
            echo self::ESC . (int) $row . ';' . (int) $column . 'H';
        }
    }

    /**
     * Saves the current cursor position by sending ANSI control code SCP to the terminal.
     * Position can then be restored with [[restoreCursorPosition()]].
     */
    public static function savePosition() {
        echo self::ESC . "s";
    }

    /**
     * Restores the cursor position saved with [[savePosition()]] by sending ANSI control code RCP to the terminal.
     */
    public static function restorePosition() {
        echo self::ESC . "u";
    }

    /**
     * Hides the cursor by sending ANSI DECTCEM code ?25l to the terminal.
     * Use [[show()]] to bring it back.
     * Do not forget to show cursor when your application exits. Cursor might stay hidden in terminal after exit.
     */
    public static function hide() {
        echo self::ESC . "?25l";
    }

    /**
     * Will show a cursor again when it has been hidden by [[hide()]]  by sending ANSI DECTCEM code ?25h to the terminal.
     */
    public static function show() {
        echo self::ESC . "?25h";
    }

    //put your code here
}
