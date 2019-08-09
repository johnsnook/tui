<?php

/**
 * @author John Snook
 * @date May 1, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace tui\events;

use \tui\helpers\Keys;
use \tui\components\Observer;

/**
 * Defines a key press event, parses the string and sets the appropriate
 * flags (Alt, Ctrl, Shift).
 * @property string $rawData The raw data as passed from the terminal emulator
 * @property string $description Description
 */
class KeyPressEvent extends \tui\base\Event {

    const EXTENDED_SHIFT = '1;2';
    const EXTENDED_ALT = '1;3';
    const EXTENDED_CTRL = '1;5';
    const CLICK = 'ClickEvent';

    public $alt = false;
    public $ctrl = false;
    //public $shift = false;
    public $key;
    private $description;
    private $rawData;
    private $keyDefs = [
        "control" => [
            "0" => " ", "1" => "a", "2" => "b", "3" => "c", "4" => "d", "5" => "e",
            "6" => "f", "7" => "g", "8" => "h", "9" => "i", "10" => "j", "11" => "k",
            "12" => "l", "13" => "m", "14" => "n", "15" => "o", "16" => "p", "17" => "q",
            "18" => "r", "19" => "s", "20" => "t", "21" => "u", "22" => "v", "23" => "w",
            "24" => "x", "25" => "y", "26" => "z", "27" => "3", "28" => "4", "29" => "5",
            "30" => "6", "31" => "7"],
        "shifted" => [33, 34, 35, 36, 37, 38, 40, 41, 58, 60, 62, 63, 64, 65,
            66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82,
            83, 84, 85, 86, 87, 88, 89, 90, 94, 95, 126],
        "ascii" => [
            "32" => "SPACE", "33" => "!", "34" => "\"", "35" => "#", "36" => "$",
            "37" => "%", "38" => "&", "39" => "'", "40" => "(", "41" => ")",
            "42" => "*", "43" => "+", "44" => ",", "45" => "-", "46" => ".",
            "47" => "/", "48" => "0", "49" => "1", "50" => "2", "51" => "3",
            "52" => "4", "53" => "5", "54" => "6", "55" => "7", "56" => "8",
            "57" => "9", "58" => ":", "59" => ";", "60" => "<", "61" => "=",
            "62" => ">", "63" => "?", "64" => "@", "65" => "A", "66" => "B",
            "67" => "C", "68" => "D", "69" => "E", "70" => "F", "71" => "G",
            "72" => "H", "73" => "I", "74" => "J", "75" => "K", "76" => "L",
            "77" => "M", "78" => "N", "79" => "O", "80" => "P", "81" => "Q",
            "82" => "R", "83" => "S", "84" => "T", "85" => "U", "86" => "V",
            "87" => "W", "88" => "X", "89" => "Y", "90" => "Z", "91" => "[",
            "92" => "\\", "93" => "]", "94" => "^", "95" => "_", "96" => "`",
            "97" => "a", "98" => "b", "99" => "c", "100" => "d", "101" => "e",
            "102" => "f", "103" => "g", "104" => "h", "105" => "i", "106" => "j",
            "107" => "k", "108" => "l", "109" => "m", "110" => "n", "111" => "o",
            "112" => "p", "113" => "q", "114" => "r", "115" => "s", "116" => "t",
            "117" => "u", "118" => "v", "119" => "w", "120" => "x", "121" => "y",
            "122" => "z", "123" => "{", "124" => "|", "125" => "}", "126" => "~"
        ],
        "extended" => [
            'A' => 'Up Arrow', 'B' => 'Down Arrow', 'C' => 'Right Arrow', 'D' => 'Left Arrow',
            '2~' => 'Insert', '3~' => 'Delete', 'H' => 'Home', 'F' => 'End',
            '5~' => 'Page Up', '6~' => 'Page Down', '1;5' => 'Control', '1;3' => 'Alt',
            '1;2' => 'Shift']
    ];

    public function setRawData($var) {
        $this->rawData = $var;
        $this->name = Observer::KEY_PRESSED;
        $this->description = Keys::describe($var);
    }

    public function getRawData() {
        return $this->rawData;
    }

    protected function processByte($byte) {
        if ($byte == 9) { #AKA ^I
            $this->key = 'Tab';
        } elseif ($byte == 10) { #AKA ^J
            $this->key = 'Enter';
        } elseif ($byte == 32) { #AKA ^J
            $this->key = 'Space';
        } elseif ($byte >= 1 && $byte < 32) {
            $this->key = $this->keyDefs["control"]["$byte"];
            $this->ctrl = true;
        } elseif ($byte > 32 && $byte <= 128) {
            if (in_array($byte, $this->keyDefs["shifted"])) {
                $this->shift = true;
            }
            $this->key = chr($byte);
        }
    }

    public function getDescription() {
        return $this->description;
//        $out = $this->ctrl ? 'CTRL-' : '';
//        $out .= $this->shift ? 'SHIFT-' : '';
//        $out .= $this->alt ? 'ALT-' : '';
//        $out .= strtolower($this->key);
//        return $out;
    }

}
