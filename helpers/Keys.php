<?php

/**
 * @author John Snook
 * @date Apr 28, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace tui\helpers;

abstract class Keys {

    const NUL = "\x0";
    const CTRL_SPACE = "\x0";
    const CTRL_A = "\x01";
    const CTRL_B = "\x02";
    const CTRL_C = "\x03";
    const CTRL_D = "\x04";
    const CTRL_E = "\x05";
    const CTRL_F = "\x06";
    const CTRL_G = "\x07";
    const CTRL_H = "\x08";
    const BACKSPACE = "\x08";
    const CTRL_I = "\x09";
    const TAB = "\x09";
    const CTRL_J = "\x0a";
    const ENTER = "\x0a";
    const CTRL_K = "\x0b";
    const CTRL_L = "\x0c";
    const CTRL_M = "\x0d";
    const CTRL_N = "\x0e";
    const CTRL_O = "\x0f";
    const CTRL_P = "\x10";
    const CTRL_Q = "\x11";
    const CTRL_R = "\x12";
    const CTRL_S = "\x13";
    const CTRL_T = "\x14";
    const CTRL_U = "\x15";
    const CTRL_V = "\x16";
    const CTRL_W = "\x17";
    const CTRL_X = "\x18";
    const CTRL_Y = "\x19";
    const CTRL_Z = "\x1a";

    /** Punctuation & number */
    const ESC = "\x1b";
    const CTRL_BRACKET_SQ_LEFT = "\x1b";
    const CTRL_BACKSLASH = "\x1c";
    const CTRL_BRACKET_SQ_RIGHT = "\x1d";
    const CTRL_SLASH = "\x1f";
    const SPACE = "\x20";
    const BANG = "\x21";
    const QUOTE_DOUBLE = "\x22";
    const HASH = "\x23";
    const DOLLA = "\x24";
    const PERCENT = "\x25";
    const AMPERSAND = "\x26";
    const QUOTE_SINGLE = "\x27";
    const PAREN_LEFT = "\x28";
    const PAREN_RIGHT = "\x29";
    const ASTERICK = "\x2a";
    const PLUS = "\x2b";
    const COMMA = "\x2c";
    const MINUS = "\x2d";
    const PERIOD = "\x2e";
    const SLASH = "\x2f";
    const NUMBER_0 = "\x30";
    const NUMBER_1 = "\x31";
    const NUMBER_2 = "\x32";
    const NUMBER_3 = "\x33";
    const NUMBER_4 = "\x34";
    const NUMBER_5 = "\x35";
    const NUMBER_6 = "\x36";
    const NUMBER_7 = "\x37";
    const NUMBER_8 = "\x38";
    const NUMBER_9 = "\x39";
    const COLON = "\x3a";
    const SEMICOLON = "\x3b";
    const BRACKET_ANGLE_LEFT = "\x3c";
    const EQUALS = "\x3d";
    const BRACKET_ANGLE_RIGHT = "\x3e";
    const QUESTION = "\x3f";
    const AT = "\x40";

    /** Uppercase Letters */
    const UC_A = "\x41";
    const UC_B = "\x42";
    const UC_C = "\x43";
    const UC_D = "\x44";
    const UC_E = "\x45";
    const UC_F = "\x46";
    const UC_G = "\x47";
    const UC_H = "\x48";
    const UC_I = "\x49";
    const UC_J = "\x4a";
    const UC_K = "\x4b";
    const UC_L = "\x4c";
    const UC_M = "\x4d";
    const UC_N = "\x4e";
    const UC_O = "\x4f";
    const UC_P = "\x50";
    const UC_Q = "\x51";
    const UC_R = "\x52";
    const UC_S = "\x53";
    const UC_T = "\x54";
    const UC_U = "\x55";
    const UC_V = "\x56";
    const UC_W = "\x57";
    const UC_X = "\x58";
    const UC_Y = "\x59";
    const UC_Z = "\x5a";

    /** More punctuation */
    const BRACKET_SQ_LEFT = "\x5b";
    const BACKSLASH = "\x5c";
    const BRACKET_SQ_RIGHT = "\x5d";
    const HAT = "\x5e";
    const UNDERSCORE = "\x5f";
    const TICK = "\x60";

    /** Lowercase Letters */
    const LC_A = "\x61";
    const LC_B = "\x62";
    const LC_C = "\x63";
    const LC_D = "\x64";
    const LC_E = "\x65";
    const LC_F = "\x66";
    const LC_G = "\x67";
    const LC_H = "\x68";
    const LC_I = "\x69";
    const LC_J = "\x6a";
    const LC_K = "\x6b";
    const LC_L = "\x6c";
    const LC_M = "\x6d";
    const LC_N = "\x6e";
    const LC_O = "\x6f";
    const LC_P = "\x70";
    const LC_Q = "\x71";
    const LC_R = "\x72";
    const LC_S = "\x73";
    const LC_T = "\x74";
    const LC_U = "\x75";
    const LC_V = "\x76";
    const LC_W = "\x77";
    const LC_X = "\x78";
    const LC_Y = "\x79";
    const LC_Z = "\x7a";

    /** Last bit of punctuation */
    const BRACKET_CURLY_LEFT = "\x7b";
    const PIPE = "\x7c";
    const BRACKET_CURLY_RIGHT = "\x7d";
    const TILDE = "\x7e";
    const CTRL_BACKSPACE = "\x7f";

    /** ESC + [ */
    const PREFIX_EXTENDED = self::ESC . self::BRACKET_SQ_LEFT;

    /** mouse actions start with ESC[< and end with an 'm' or 'M' */
    const PREFIX_MOUSE = self::PREFIX_EXTENDED . self::BRACKET_ANGLE_LEFT;

    /** Function Keys */
    const F1 = self::ESC . self::UC_O . self::UC_P;
    const F2 = self::ESC . self::UC_O . self::UC_Q;
    const F3 = self::ESC . self::UC_O . self::UC_R;
    const F4 = self::ESC . self::UC_O . self::UC_S;
    const F5 = self::PREFIX_EXTENDED . self::NUMBER_1 . self::NUMBER_5 . self::TILDE;
    const F6 = self::PREFIX_EXTENDED . self::NUMBER_1 . self::NUMBER_7 . self::TILDE;
    const F7 = self::PREFIX_EXTENDED . self::NUMBER_1 . self::NUMBER_8 . self::TILDE;
    const F8 = self::PREFIX_EXTENDED . self::NUMBER_1 . self::NUMBER_9 . self::TILDE;
    const F9 = self::PREFIX_EXTENDED . self::NUMBER_2 . self::NUMBER_0 . self::TILDE;
    const F10 = self::PREFIX_EXTENDED . self::NUMBER_2 . self::NUMBER_1 . self::TILDE;
    const F11 = self::PREFIX_EXTENDED . self::NUMBER_2 . self::NUMBER_3 . self::TILDE;
    const F12 = self::PREFIX_EXTENDED . self::NUMBER_2 . self::NUMBER_4 . self::TILDE;

    /** numpad */
    const NUMPAD_0 = self::PREFIX_EXTENDED . self::NUMBER_2 . self::TILDE;
    const NUMPAD_1 = self::PREFIX_EXTENDED . self::UC_F;
    const NUMPAD_2 = self::ARROW_DOWN;
    const NUMPAD_3 = self::PREFIX_EXTENDED . self::NUMBER_3 . self::TILDE;
    const NUMPAD_4 = self::ARROW_LEFT;
    const NUMPAD_6 = self::ARROW_RIGHT;
    const NUMPAD_7 = self::PREFIX_EXTENDED . self::UC_H;
    const NUMPAD_8 = self::ARROW_UP;
    const NUMPAD_9 = self::PREFIX_EXTENDED . self::NUMBER_5 . self::TILDE;

    /** Extended */
    const INSERT = self::PREFIX_EXTENDED . self::NUMBER_2 . self::TILDE;
    const DELETE = self::PREFIX_EXTENDED . self::NUMBER_3 . self::TILDE;
    const HOME = self::PREFIX_EXTENDED . self::UC_H;
    const END = self::PREFIX_EXTENDED . self::UC_F;
    const PG_UP = self::PREFIX_EXTENDED . self::NUMBER_5 . self::TILDE;
    const PG_DOWN = self::PREFIX_EXTENDED . self::NUMBER_6 . self::TILDE;
    const ARROW_UP = self::PREFIX_EXTENDED . self::UC_A;
    const ARROW_DOWN = self::PREFIX_EXTENDED . self::UC_B;
    const ARROW_LEFT = self::PREFIX_EXTENDED . self::UC_D;
    const ARROW_RIGHT = self::PREFIX_EXTENDED . self::UC_C;

    /** Extended */
    const ALT_INSERT = self::PREFIX_EXTENDED . self::NUMBER_2 . self::SEMICOLON . self::NUMBER_3 . self::TILDE;
    const ALT_DELETE = self::PREFIX_EXTENDED . self::NUMBER_3 . self::SEMICOLON . self::NUMBER_3 . self::TILDE;
    const ALT_HOME = self::ESC . self::PREFIX_EXTENDED . self::UC_H;
    const ALT_END = self::ESC . self::PREFIX_EXTENDED . self::UC_F;
    const CTRL_HOME = self::PREFIX_EXTENDED . self::NUMBER_1 . self::SEMICOLON . self::NUMBER_5 . self::UC_H;
    const CTRL_END = self::PREFIX_EXTENDED . self::NUMBER_1 . self::SEMICOLON . self::NUMBER_5 . self::UC_F;
    const ALT_CTRL_HOME = self::ESC . self::PREFIX_EXTENDED . self::NUMBER_1 . self::SEMICOLON . self::NUMBER_5 . self::UC_H;
    const ALT_CTRL_END = self::ESC . self::PREFIX_EXTENDED . self::NUMBER_1 . self::SEMICOLON . self::NUMBER_5 . self::UC_F;
    const CTRL_ARROW_UP = self::PREFIX_EXTENDED . self::NUMBER_1 . self::SEMICOLON . self::NUMBER_5 . self::UC_A;
    const CTRL_ARROW_DOWN = self::PREFIX_EXTENDED . self::NUMBER_1 . self::SEMICOLON . self::NUMBER_5 . self::UC_B;
    const CTRL_ARROW_LEFT = self::PREFIX_EXTENDED . self::NUMBER_1 . self::SEMICOLON . self::NUMBER_5 . self::UC_D;
    const CTRL_ARROW_RIGHT = self::PREFIX_EXTENDED . self::NUMBER_1 . self::SEMICOLON . self::NUMBER_5 . self::UC_C;
    const SHIFT_CTRL_ARROW_UP = self::ESC . self::UC_O . self::UC_A;
    const SHIFT_CTRL_ARROW_DOWN = self::ESC . self::UC_O . self::UC_B;
    const SHIFT_CTRL_ARROW_LEFT = self::ESC . self::UC_O . self::UC_D;
    const SHIFT_CTRL_ARROW_RIGHT = self::ESC . self::UC_O . self::UC_C;
    const ALT_ARROW_UP = self::PREFIX_EXTENDED . self::NUMBER_1 . self::SEMICOLON . self::NUMBER_3 . self::UC_A;
    const ALT_ARROW_DOWN = self::PREFIX_EXTENDED . self::NUMBER_1 . self::SEMICOLON . self::NUMBER_3 . self::UC_B;
    const ALT_ARROW_LEFT = self::PREFIX_EXTENDED . self::NUMBER_1 . self::SEMICOLON . self::NUMBER_3 . self::UC_D;
    const ALT_ARROW_RIGHT = self::PREFIX_EXTENDED . self::NUMBER_1 . self::SEMICOLON . self::NUMBER_3 . self::UC_C;
    const SHIFT_ALT_ARROW_UP = self::PREFIX_EXTENDED . self::NUMBER_1 . self::SEMICOLON . self::NUMBER_2 . self::UC_A;
    const SHIFT_ALT_ARROW_DOWN = self::PREFIX_EXTENDED . self::NUMBER_1 . self::SEMICOLON . self::NUMBER_2 . self::UC_B;
    const SHIFT_ALT_ARROW_LEFT = self::PREFIX_EXTENDED . self::NUMBER_1 . self::SEMICOLON . self::NUMBER_2 . self::UC_D;
    const SHIFT_ALT_ARROW_RIGHT = self::PREFIX_EXTENDED . self::NUMBER_1 . self::SEMICOLON . self::NUMBER_2 . self::UC_C;

    /** Alt + char */
    const ALT_CTRL_SPACE = self::ESC . "\x0";
    const ALT_CTRL_A = self::ESC . "\x01";
    const ALT_CTRL_B = self::ESC . "\x02";
    const ALT_CTRL_C = self::ESC . "\x03";
    const ALT_CTRL_D = self::ESC . "\x04";
    const ALT_CTRL_E = self::ESC . "\x05";
    const ALT_CTRL_F = self::ESC . "\x06";
    const ALT_CTRL_G = self::ESC . "\x07";
    const ALT_CTRL_H = self::ESC . "\x08";
    const ALT_BACKSPACE = self::ESC . "\x08";
    const ALT_CTRL_I = self::ESC . "\x09";
    const ALT_TAB = self::ESC . "\x09";
    const ALT_CTRL_J = self::ESC . "\x0a";
    const ALT_ENTER = self::ESC . "\x0a";
    const ALT_CTRL_K = self::ESC . "\x0b";
    const ALT_CTRL_L = self::ESC . "\x0c";
    const ALT_CTRL_M = self::ESC . "\x0d";
    const ALT_CTRL_N = self::ESC . "\x0e";
    const ALT_CTRL_O = self::ESC . "\x0f";
    const ALT_CTRL_P = self::ESC . "\x10";
    const ALT_CTRL_Q = self::ESC . "\x11";
    const ALT_CTRL_R = self::ESC . "\x12";
    const ALT_CTRL_S = self::ESC . "\x13";
    const ALT_CTRL_T = self::ESC . "\x14";
    const ALT_CTRL_U = self::ESC . "\x15";
    const ALT_CTRL_V = self::ESC . "\x16";
    const ALT_CTRL_W = self::ESC . "\x17";
    const ALT_CTRL_X = self::ESC . "\x18";
    const ALT_CTRL_Y = self::ESC . "\x19";
    const ALT_CTRL_Z = self::ESC . "\x1a";

    /** Punctuation & number */
    const ALT_CTRL_BRACKET_SQ_LEFT = self::ESC . "\x1b";
    const ALT_CTRL_BACKSLASH = self::ESC . "\x1c";
    const ALT_CTRL_BRACKET_SQ_RIGHT = self::ESC . "\x1d";
    const ALT_CTRL_SLASH = self::ESC . "\x1f";
    const ALT_SPACE = self::ESC . self::SPACE;
    const ALT_BANG = self::ESC . self::BANG;
    const ALT_QUOTE_DOUBLE = self::ESC . self::QUOTE_DOUBLE;
    const ALT_HASH = self::ESC . self::HASH;
    const ALT_DOLLA = self::ESC . self::DOLLA;
    const ALT_PERCENT = self::ESC . self::PERCENT;
    const ALT_AMPERSAND = self::ESC . self::AMPERSAND;
    const ALT_QUOTE_SINGLE = self::ESC . self::QUOTE_SINGLE;
    const ALT_PAREN_LEFT = self::ESC . "\x28";
    const ALT_PAREN_RIGHT = self::ESC . "\x29";
    const ALT_ASTERICK = self::ESC . "\x2a";
    const ALT_PLUS = self::ESC . "\x2b";
    const ALT_COMMA = self::ESC . "\x2c";
    const ALT_MINUS = self::ESC . "\x2d";
    const ALT_PERIOD = self::ESC . "\x2e";
    const ALT_SLASH = self::ESC . "\x2f";
    const ALT_NUMBER_0 = self::ESC . "\x30";
    const ALT_NUMBER_1 = self::ESC . "\x31";
    const ALT_NUMBER_2 = self::ESC . "\x32";
    const ALT_NUMBER_3 = self::ESC . "\x33";
    const ALT_NUMBER_4 = self::ESC . "\x34";
    const ALT_NUMBER_5 = self::ESC . "\x35";
    const ALT_NUMBER_6 = self::ESC . "\x36";
    const ALT_NUMBER_7 = self::ESC . "\x37";
    const ALT_NUMBER_8 = self::ESC . "\x38";
    const ALT_NUMBER_9 = self::ESC . "\x39";
    const ALT_SEMICOLON = self::ESC . "\x3a";
    const ALT_COLON = self::ESC . "\x3b";
    const ALT_BRACKET_ANGLE_LEFT = self::ESC . "\x3c";
    const ALT_EQUALS = self::ESC . "\x3d";
    const ALT_BRACKET_ANGLE_RIGHT = self::ESC . "\x3e";
    const ALT_QUESTION = self::ESC . "\x3f";
    const ALT_AT = self::ESC . "\x40";

    /** Alt characters */

    /** Uppercase Letters */
    const ALT_UC_A = self::ESC . "\x41";
    const ALT_UC_B = self::ESC . "\x42";
    const ALT_UC_C = self::ESC . "\x43";
    const ALT_UC_D = self::ESC . "\x44";
    const ALT_UC_E = self::ESC . "\x45";
    const ALT_UC_F = self::ESC . "\x46";
    const ALT_UC_G = self::ESC . "\x47";
    const ALT_UC_H = self::ESC . "\x48";
    const ALT_UC_I = self::ESC . "\x49";
    const ALT_UC_J = self::ESC . "\x4a";
    const ALT_UC_K = self::ESC . "\x4b";
    const ALT_UC_L = self::ESC . "\x4c";
    const ALT_UC_M = self::ESC . "\x4d";
    const ALT_UC_N = self::ESC . "\x4e";
    const ALT_UC_O = self::ESC . "\x4f";
    const ALT_UC_P = self::ESC . "\x50";
    const ALT_UC_Q = self::ESC . "\x51";
    const ALT_UC_R = self::ESC . "\x52";
    const ALT_UC_S = self::ESC . "\x53";
    const ALT_UC_T = self::ESC . "\x54";
    const ALT_UC_U = self::ESC . "\x55";
    const ALT_UC_V = self::ESC . "\x56";
    const ALT_UC_W = self::ESC . "\x57";
    const ALT_UC_X = self::ESC . "\x58";
    const ALT_UC_Y = self::ESC . "\x59";
    const ALT_UC_Z = self::ESC . "\x5a";

    /** More punctuation */
    const ALT_BRACKET_SQ_LEFT = self::ESC . "\x5b";
    const ALT_BACKSLASH = self::ESC . "\x5c";
    const ALT_BRACKET_SQ_RIGHT = self::ESC . "\x5d";
    const ALT_HAT = self::ESC . "\x5e";
    const ALT_UNDERSCORE = self::ESC . "\x5f";
    const ALT_TICK = self::ESC . "\x60";

    /** Lowercase Letters */
    const ALT_LC_A = self::ESC . "\x61";
    const ALT_LC_B = self::ESC . "\x62";
    const ALT_LC_C = self::ESC . "\x63";
    const ALT_LC_D = self::ESC . "\x64";
    const ALT_LC_E = self::ESC . "\x65";
    const ALT_LC_F = self::ESC . "\x66";
    const ALT_LC_G = self::ESC . "\x67";
    const ALT_LC_H = self::ESC . "\x68";
    const ALT_LC_I = self::ESC . "\x69";
    const ALT_LC_J = self::ESC . "\x6a";
    const ALT_LC_K = self::ESC . "\x6b";
    const ALT_LC_L = self::ESC . "\x6c";
    const ALT_LC_M = self::ESC . "\x6d";
    const ALT_LC_N = self::ESC . "\x6e";
    const ALT_LC_O = self::ESC . "\x6f";
    const ALT_LC_P = self::ESC . "\x70";
    const ALT_LC_Q = self::ESC . "\x71";
    const ALT_LC_R = self::ESC . "\x72";
    const ALT_LC_S = self::ESC . "\x73";
    const ALT_LC_T = self::ESC . "\x74";
    const ALT_LC_U = self::ESC . "\x75";
    const ALT_LC_V = self::ESC . "\x76";
    const ALT_LC_W = self::ESC . "\x77";
    const ALT_LC_X = self::ESC . "\x78";
    const ALT_LC_Y = self::ESC . "\x79";
    const ALT_LC_Z = self::ESC . "\x7a";

    /** Last bit of punctuation */
    const ALT_BRACKET_CURLY_LEFT = self::ESC . "\x7b";
    const ALT_PIPE = self::ESC . "\x7c";
    const ALT_BRACKET_CURLY_RIGHT = self::ESC . "\x7d";
    const ALT_TILDE = self::ESC . "\x7e";

    public static $pretty = false;

    public static function describe($string) {
        static $simple = [
            self::NUL => 'NULL', self::CTRL_A => 'CTRL-A', self::CTRL_B => 'CTRL-B',
            self::CTRL_C => 'CTRL-C', self::CTRL_D => 'CTRL-D', self::CTRL_E => 'CTRL-E',
            self::CTRL_F => 'CTRL-F', self::CTRL_G => 'CTRL-G', #self::CTRL_H => 'CTRL-H',
            self::CTRL_H => 'BACKSPACE', self::CTRL_I => 'CTRL-I', self::CTRL_J => 'TAB',
            self::CTRL_K => 'RETURN', self::CTRL_L => 'CTRL-L', self::CTRL_M => 'CTRL-M',
            self::CTRL_N => 'CTRL-N', self::CTRL_O => 'CTRL-O', self::CTRL_P => 'CTRL-P',
            self::CTRL_Q => 'CTRL-Q', self::CTRL_R => 'CTRL-R', self::CTRL_S => 'CTRL-S',
            self::CTRL_T => 'CTRL-T', self::CTRL_U => 'CTRL-U', self::CTRL_V => 'CTRL-V',
            self::CTRL_W => 'CTRL-W', self::CTRL_X => 'CTRL-X', self::CTRL_Y => 'CTRL-Y',
            self::CTRL_Z => 'CTRL-Z', self::ESC => 'ESC', self::CTRL_BRACKET_SQ_RIGHT => "CTRL-]",
            "\x1e" => "", self::CTRL_SLASH => "CTRL-/", self::SPACE => "SPACE",
            self::CTRL_BACKSLASH => "CTRL-\\",
            self::BANG => "!", self::QUOTE_DOUBLE => "\"", self::HASH => "#",
            self::DOLLA => "$", self::PERCENT => "%", self::AMPERSAND => "&",
            self::QUOTE_SINGLE => "'", self::PAREN_LEFT => "(", self::PAREN_RIGHT => ")",
            self::ASTERICK => "*", self::PLUS => "+", self::COMMA => ",",
            self::MINUS => "-", self::PERIOD => ".", self::SLASH => "/",
            self::NUMBER_0 => "0", self::NUMBER_1 => "1", self::NUMBER_2 => "2",
            self::NUMBER_3 => "4", self::NUMBER_4 => "5", self::NUMBER_5 => "5",
            self::NUMBER_6 => "6", self::NUMBER_7 => "7", self::NUMBER_8 => "8",
            self::NUMBER_9 => "9", self::SEMICOLON => ";", self::COLON => ":",
            self::BRACKET_ANGLE_LEFT => "<", self::EQUALS => "=", self::BRACKET_ANGLE_RIGHT => ">",
            self::QUESTION => "?", self::AT => "@", self::UC_A => "A",
            self::UC_B => "B", self::UC_C => "C", self::UC_D => "D",
            self::UC_E => "E", self::UC_F => "F", self::UC_G => "G",
            self::UC_H => "H", self::UC_I => "I", self::UC_J => "J",
            self::UC_K => "K", self::UC_L => "L", self::UC_M => "M",
            self::UC_N => "N", self::UC_O => "O", self::UC_P => "P",
            self::UC_Q => "Q", self::UC_R => "R", self::UC_S => "S",
            self::UC_T => "T", self::UC_U => "U", self::UC_V => "V",
            self::UC_W => "W", self::UC_X => "X", self::UC_Y => "Y",
            self::UC_Z => "Z", self::BRACKET_SQ_LEFT => "[", self::BACKSLASH => "\\",
            self::BRACKET_SQ_RIGHT => "]", self::HAT => "^", self::UNDERSCORE => "_",
            self::TICK => "`", self::LC_A => "a", self::LC_B => "b",
            self::LC_C => "c", self::LC_D => "d", self::LC_E => "e",
            self::LC_F => "f", self::LC_G => "g", self::LC_H => "h",
            self::LC_I => "i", self::LC_J => "j", self::LC_K => "k",
            self::LC_L => "l", self::LC_M => "m", self::LC_N => "n",
            self::LC_O => "o", self::LC_P => "p", self::LC_Q => "q",
            self::LC_R => "r", self::LC_S => "s", self::LC_T => "t",
            self::LC_U => "u", self::LC_V => "v", self::LC_W => "w",
            self::LC_X => "x", self::LC_Y => "y", self::LC_Z => "z",
            self::BRACKET_CURLY_LEFT => "{", self::PIPE => "|", self::BRACKET_CURLY_RIGHT => "}",
            self::TILDE => "~",
        ];
        static $alt = [
            self::ALT_CTRL_A => 'ALT-CTRL-A', self::ALT_CTRL_B => 'ALT-CTRL-B',
            self::ALT_CTRL_C => 'ALT-CTRL-C', self::ALT_CTRL_D => 'ALT-CTRL-D',
            self::ALT_CTRL_E => 'ALT-CTRL-E', self::ALT_CTRL_F => 'ALT-CTRL-F',
            self::ALT_CTRL_G => 'ALT-CTRL-G', #self::ALT_CTRL_H => 'ALT-CTRL-H',
            self::ALT_CTRL_H => 'ALT-BACKSPACE', self::ALT_CTRL_I => 'ALT-CTRL-I',
            self::ALT_CTRL_J => 'ALT-TAB', self::ALT_CTRL_K => 'ALT-RETURN',
            self::ALT_CTRL_A => 'ALT-CTRL-L', self::ALT_CTRL_M => 'ALT-CTRL-M',
            self::ALT_CTRL_N => 'ALT-CTRL-N', self::ALT_CTRL_O => 'ALT-CTRL-O',
            self::ALT_CTRL_P => 'ALT-CTRL-P', self::ALT_CTRL_Q => 'ALT-CTRL-Q',
            self::ALT_CTRL_R => 'ALT-CTRL-R', self::ALT_CTRL_S => 'ALT-CTRL-S',
            self::ALT_CTRL_T => 'ALT-CTRL-T', self::ALT_CTRL_U => 'ALT-CTRL-U',
            self::ALT_CTRL_V => 'ALT-CTRL-V', self::ALT_CTRL_W => 'ALT-CTRL-W',
            self::ALT_CTRL_X => 'ALT-CTRL-X', self::ALT_CTRL_Y => 'ALT-CTRL-Y',
            self::ALT_CTRL_Z => 'ALT-CTRL-Z', self::ALT_CTRL_BRACKET_SQ_LEFT => "ALT-CTRL-[",
            self::ALT_CTRL_BRACKET_SQ_RIGHT => "ALT-CTRL-]", "\x1e" => "What did you press?!!",
            self::ALT_CTRL_SLASH => "ALT-CTRL-/", self::ALT_SPACE => "ALT-SPACE",
            self::ALT_BANG => "ALT-!", self::ALT_QUOTE_DOUBLE => "ALT-\"",
            self::ALT_HASH => "ALT-#", self::ALT_DOLLA => "ALT-$",
            self::ALT_PERCENT => "ALT-%", self::ALT_AMPERSAND => "ALT-&",
            self::ALT_QUOTE_SINGLE => "ALT-'", self::ALT_PAREN_LEFT => "ALT-(",
            self::ALT_PAREN_RIGHT => "ALT-)", self::ALT_ASTERICK => "ALT-*",
            self::ALT_PLUS => "ALT-+", self::ALT_COMMA => "ALT-,",
            self::ALT_MINUS => "ALT--", self::ALT_PERIOD => "ALT-.",
            self::ALT_SLASH => "ALT-/", self::ALT_NUMBER_0 => "ALT-0",
            self::ALT_NUMBER_1 => "ALT-1", self::ALT_NUMBER_2 => "ALT-2",
            self::ALT_NUMBER_3 => "ALT-4", self::ALT_NUMBER_4 => "ALT-5",
            self::ALT_NUMBER_5 => "ALT-5", self::ALT_NUMBER_6 => "ALT-6",
            self::ALT_NUMBER_7 => "ALT-7", self::ALT_NUMBER_8 => "ALT-8",
            self::ALT_NUMBER_9 => "ALT-9", self::ALT_SEMICOLON => "ALT-;",
            self::ALT_COLON => "ALT-:", self::ALT_BRACKET_ANGLE_LEFT => "ALT-<",
            self::ALT_EQUALS => "ALT-=", self::ALT_BRACKET_ANGLE_RIGHT => "ALT->",
            self::ALT_QUESTION => "ALT-?", self::ALT_AT => "ALT-@",
            self::ALT_UC_A => "ALT-A", self::ALT_UC_B => "ALT-B",
            self::ALT_UC_C => "ALT-C", self::ALT_UC_D => "ALT-D",
            self::ALT_UC_E => "ALT-E", self::ALT_UC_F => "ALT-F",
            self::ALT_UC_G => "ALT-G", self::ALT_UC_H => "ALT-H",
            self::ALT_UC_I => "ALT-I", self::ALT_UC_J => "ALT-J",
            self::ALT_UC_K => "ALT-K", self::ALT_UC_L => "ALT-L",
            self::ALT_UC_M => "ALT-M", self::ALT_UC_N => "ALT-N",
            self::ALT_UC_O => "ALT-O", self::ALT_UC_P => "ALT-P",
            self::ALT_UC_Q => "ALT-Q", self::ALT_UC_R => "ALT-R",
            self::ALT_UC_S => "ALT-S", self::ALT_UC_T => "ALT-T",
            self::ALT_UC_U => "ALT-U", self::ALT_UC_V => "ALT-V",
            self::ALT_UC_W => "ALT-W", self::ALT_UC_X => "ALT-X",
            self::ALT_UC_Y => "ALT-Y", self::ALT_UC_Z => "ALT-Z",
            self::ALT_BRACKET_SQ_LEFT => "ALT-[", self::ALT_BACKSLASH => "ALT-\\",
            self::ALT_BRACKET_SQ_RIGHT => "ALT-]", self::ALT_HAT => "ALT-^",
            self::ALT_UNDERSCORE => "ALT-_", self::ALT_TICK => "ALT-`",
            self::ALT_LC_A => "ALT-a", self::ALT_LC_B => "ALT-b",
            self::ALT_LC_C => "ALT-c", self::ALT_LC_D => "ALT-d",
            self::ALT_LC_E => "ALT-e", self::ALT_LC_F => "ALT-f",
            self::ALT_LC_G => "ALT-g", self::ALT_LC_H => "ALT-h",
            self::ALT_LC_I => "ALT-i", self::ALT_LC_J => "ALT-j",
            self::ALT_LC_K => "ALT-k", self::ALT_LC_L => "ALT-l",
            self::ALT_LC_M => "ALT-m", self::ALT_LC_N => "ALT-n",
            self::ALT_LC_O => "ALT-o", self::ALT_LC_P => "ALT-p",
            self::ALT_LC_Q => "ALT-q", self::ALT_LC_R => "ALT-r",
            self::ALT_LC_S => "ALT-s", self::ALT_LC_T => "ALT-t",
            self::ALT_LC_U => "ALT-u", self::ALT_LC_V => "ALT-v",
            self::ALT_LC_W => "ALT-w", self::ALT_LC_X => "ALT-x",
            self::ALT_LC_Y => "ALT-y", self::ALT_LC_Z => "ALT-z",
            self::ALT_BRACKET_CURLY_LEFT => "ALT-{", self::ALT_PIPE => "ALT-|",
            self::ALT_BRACKET_CURLY_RIGHT => "ALT-}", self::ALT_TILDE => "ALT-~",
        ];
        static $extended = [
            /** Function Keys */
            self::F1 => 'F1', self::F2 => 'F2', self::F3 => 'F3',
            self::F4 => 'F4', self::F5 => 'F5', self::F6 => 'F6',
            self::F7 => 'F7', self::F8 => 'F8', self::F9 => 'F9',
            self::F10 => 'F10', self::F11 => 'F11', self::F12 => 'F12',
            /** numpad */
            self::NUMPAD_0 => 'NUMPAD 0', self::NUMPAD_1 => 'NUMPAD 1',
            self::NUMPAD_2 => 'DOWN ARROW', self::NUMPAD_3 => 'NUMPAD 3',
            self::NUMPAD_4 => 'LEFT ARROW', self::NUMPAD_6 => 'RIGHT ARROW',
            self::NUMPAD_7 => 'NUMPAD 7', self::NUMPAD_8 => 'UP ARROW',
            self::NUMPAD_9 => 'NUMPAD 9', /** Extended */
            self::INSERT => 'INSERT', self::DELETE => 'DELETE',
            self::HOME => 'HOME', self::END => 'END',
            self::PG_UP => 'PAGE UP', self::PG_DOWN => 'PAGE DOWN',
            self::ARROW_UP => 'UP ARROW', self::ARROW_DOWN => 'DOWN ARROW',
            self::ARROW_LEFT => 'LEFT ARROW', self::ARROW_RIGHT => 'RIGHT ARROW',
            /** Extended */
            self::ALT_INSERT => 'ALT-INSERT', self::ALT_DELETE => 'ALT-DELETE',
            self::ALT_HOME => 'ALT-HOME', self::ALT_END => 'ALT-END',
            self::ALT_CTRL_HOME => 'ALT-CTRL-HOME', self::ALT_CTRL_END => 'ALT-CTRL-END',
            self::CTRL_ARROW_UP => 'CTRL-UP ARROW', self::CTRL_ARROW_DOWN => 'CTRL-DOWN ARROW',
            self::CTRL_ARROW_LEFT => 'CTRL-LEFT ARROW', self::CTRL_ARROW_RIGHT => 'CTRL-RIGHT ARROW',
            self::SHIFT_CTRL_ARROW_UP => 'SHIFT-CTRL-UP ARROW', self::SHIFT_CTRL_ARROW_DOWN => 'SHIFT-CTRL-DOWN ARROW',
            self::SHIFT_CTRL_ARROW_LEFT => 'SHIFT-CTRL-LEFT ARROW', self::SHIFT_CTRL_ARROW_RIGHT => 'SHIFT-CTRL-RIGHT ARROW',
            self::ALT_ARROW_UP => 'ALT-UP ARROW', self::ALT_ARROW_DOWN => 'ALT-DOWN ARROW',
            self::ALT_ARROW_LEFT => 'ALT-LEFT ARROW', self::ALT_ARROW_RIGHT => 'ALT-RIGHT ARROW',
            self::SHIFT_ALT_ARROW_UP => 'SHIFT-ALT-UP ARROW', self::SHIFT_ALT_ARROW_DOWN => 'SHIFT-ALT-DOWN ARROW',
            self::SHIFT_ALT_ARROW_LEFT => 'SHIFT-ALT-LEFT ARROW', self::SHIFT_ALT_ARROW_RIGHT => 'SHIFT-ALT-RIGHT ARROW',
        ];

        if ((strlen($string) === 1) && key_exists($string, $simple)) {
            $out = $simple[$string];
        } elseif ((strlen($string) === 2) && key_exists($string, $alt)) {
            $out = $alt[$string];
        } elseif (key_exists($string, $extended) || $string === self::ALT_ARROW_UP) {
            $out = $extended[$string];
        }
        if (empty($out)) {
            throw new \Exception(json_encode(ord($string)) . " wasn't found. Length = " . strlen($string));
        }

        if (self::$pretty) {
            return ucwords($out, " -");
        } else {
            return $out;
        }
    }

}
