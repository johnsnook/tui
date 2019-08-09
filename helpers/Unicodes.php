<?php

/**
 * @author John Snook
 * @date May 20, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace tui\helpers;

/**
 * Unicode characters of interest
 */
abstract class Unicodes {

    const CIRCLE_EMPTY = '⚪';
    const CIRCLE_FULL = '⚪';
    const PEACE = '☮';
    const TRIANGLE_UP = '▲';
    const TRIANGLE_RIGHT = '►';
    const TRIANGLE_DOWN = '▼';
    const TRIANGLE_LEFT = '◄';
    const THREE_LINES = '☰';
    const BLACK_SQUARE = '■';
    const ARROW_LEFT = '←';
    const ARROW_UP = '↑';
    const ARROW_RIGHT = '→';
    const ARROW_DOWN = '↓';
    const ARROW_DOUBLE_HORIZONTAL = '↔';
    const ARROW_DOUBLE_VERTICAL = '↕';
    const HOURGLASS = '⌛';
    const BOX_CHECKED = '☑';
    const BOX_XD = '☒';
    const BOX_UNCHECKED = '☐';
    const SMILEY = '☺';
    const COFFEE = '☕';
    const LIGHTNING = '⚡';
    const SCISSORS = '✂';
    const PENCIL = '✐';
    const BLOCK_UPPER_HALF = '▀';
    const BLOCK_LOWER_HALF = '▄';
    const BLOCK_LEFT_HALF = '▌';
    const BLOCK_RIGHT_HALF = '▐';
    const ELIPSIS_HORIZONTAL = '…';
    const ELIPSIS_VERTICAL = '⁞';

    /** single border */
    const SINGLE_HORIZONTAL = "─";
    const SINGLE_VERTICAL = "│";
    const SINGLE_TOP_LEFT = "┌";
    const SINGLE_TOP_MID = "┬";
    const SINGLE_TOP_RIGHT = "┐";
    const SINGLE_RIGHT_MID = "┤";
    const SINGLE_BOTTOM_RIGHT = "┘";
    const SINGLE_BOTTOM_MID = "┴";
    const SINGLE_BOTTOM_LEFT = "└";
    const SINGLE_LEFT_MID = "├";
    const SINGLE_CROSS = "┼";

    /** Double border */
    const DOUBLE_HORIZONTAL = "═";
    const DOUBLE_VERTICAL = "║";
    const DOUBLE_TOP_LEFT = "╔";
    const DOUBLE_TOP_MID = "╦";
    const DOUBLE_TOP_RIGHT = "╗";
    const DOUBLE_RIGHT_MID = "╣";
    const DOUBLE_BOTTOM_RIGHT = "╝";
    const DOUBLE_BOTTOM_MID = "╩";
    const DOUBLE_BOTTOM_LEFT = "╚";
    const DOUBLE_LEFT_MID = "╠";
    const DOUBLE_CROSS = "╬";

    public static $futhark = [
        'ᚠ', 'ᚡ', 'ᚢ', 'ᚣ', 'ᚤ', 'ᚥ', 'ᚦ', 'ᚧ', 'ᚨ', 'ᚩ', 'ᚪ', 'ᚫ', 'ᚬ', 'ᚭ',
        'ᚮ', 'ᚯ', 'ᚰ', 'ᚱ', 'ᚲ', 'ᚳ', 'ᚴ', 'ᚵ', 'ᚶ', 'ᚷ', 'ᚸ', 'ᚹ', 'ᚺ', 'ᚻ',
        'ᚼ', 'ᚽ', 'ᚾ', 'ᚿ', 'ᛀ', 'ᛁ', 'ᛂ', 'ᛃ', 'ᛄ', 'ᛅ', 'ᛆ', 'ᛇ', 'ᛈ', 'ᛉ',
        'ᛊ', 'ᛋ', 'ᛌ', 'ᛍ', 'ᛎ', 'ᛏ', 'ᛐ', 'ᛑ', 'ᛒ', 'ᛓ', 'ᛔ', 'ᛕ', 'ᛖ', 'ᛗ',
        'ᛘ', 'ᛙ', 'ᛚ', 'ᛛ', 'ᛜ', 'ᛝ', 'ᛞ', 'ᛟ', 'ᛠ', 'ᛡ', 'ᛢ', 'ᛣ', 'ᛤ', 'ᛥ',
        'ᛦ', 'ᛧ', 'ᛨ', 'ᛩ', 'ᛪ', '᛫', '᛬', '᛭', 'ᛮ', 'ᛯ', 'ᛰ'
    ];

    /**
     * Given a unicode numeric value, returns that character
     * @param integer $code
     * @return string
     */
    public static function uchr($code) {
        return html_entity_decode('&#x' . hexdec($code) . ';', ENT_NOQUOTES, 'UTF-8');
    }

    /**
     * This function returns the input string padded on the left, the right, or
     * both sides to the specified padding length. If the optional argument
     * pad_string is not supplied, the input is padded with spaces, otherwise it
     * is padded with characters from pad_string up to the limit.
     * @param string $input The input string.
     * @param int $pad_lengthgth If the value of pad_length is negative, less than,
     * or equal to the length of the input string, no padding takes place, and
     * input will be returned.
     * @param string $pad_stringing Note: The pad_string may be truncated if the
     * required number of padding characters can't be evenly divided by the
     * pad_string's length.
     * @param int $pad_type Optional argument pad_type can be STR_PAD_RIGHT,
     * STR_PAD_LEFT, or STR_PAD_BOTH. If pad_type is not specified it is assumed
     * to be STR_PAD_RIGHT.
     * @param string $encoding
     * @return string Returns the padded string.
     */
    #public static function mbStringPad($input, $pad_lengthgth, $pad_stringing, $pad_type, $encoding = "UTF-8") {
    #return str_pad($input, strlen($input) - mb_strlen($input, $encoding) + $pad_lengthgth, $pad_stringing, $pad_type);
    #}
#mb_internal_encoding('utf-8'); // @important

    function mbStringPad($input, $pad_length, $pad_string = ' ', $pad_type = STR_PAD_RIGHT, $encoding = "UTF-8") {
        $input_len = mb_strlen($input);
        $pad_string_len = mb_strlen($pad_string);
        if (!$input_len && ($pad_type == STR_PAD_RIGHT || $pad_type == STR_PAD_LEFT)) {
            $input_len = 1; // @debug
        }
        if (!$pad_length || !$pad_string_len || $pad_length <= $input_len) {
            return $input;
        }

        $result = null;
        $repeat = ceil($input_len - $pad_string_len + $pad_length);
        if ($pad_type == STR_PAD_RIGHT) {
            $result = $input . str_repeat($pad_string, $repeat);
            $result = mb_substr($result, 0, $pad_length);
        } else if ($pad_type == STR_PAD_LEFT) {
            $result = str_repeat($pad_string, $repeat) . $input;
            $result = mb_substr($result, -$pad_length);
        } else if ($pad_type == STR_PAD_BOTH) {
            $length = ($pad_length - $input_len) / 2;
            $repeat = ceil($length / $pad_string_len);
            $result = mb_substr(str_repeat($pad_string, $repeat), 0, floor($length))
                    . $input
                    . mb_substr(str_repeat($pad_string, $repeat), 0, ceil($length));
        }

        return $result;
    }

}
