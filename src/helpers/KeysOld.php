<?php

/**
 * @link http://www.tuiframework.com/
 * @copyright Copyright (c) 2008 Tui Software LLC
 * @license http://www.tuiframework.com/license/
 */
/**
 * @author John Snook
 * @date Apr 28, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 * Description of Keys
 */

namespace tui\helpers;

abstract class KeysOld {

    const CTRL_SPACE = 0;
    const CTRL_A = 1;
    const CTRL_B = 2;
    const CTRL_C = 3;
    const CTRL_D = 4;
    const CTRL_E = 5;
    const CTRL_F = 6;
    const CTRL_G = 7;
    const CTRL_H = 8;
    const CTRL_I = 9;
    const CTRL_J = 10;
    const CTRL_K = 11;
    const CTRL_L = 12;
    const CTRL_M = 13;
    const CTRL_N = 14;
    const CTRL_O = 15;
    const CTRL_P = 16;
    const CTRL_Q = 17;
    const CTRL_R = 18;
    const CTRL_S = 19;
    const CTRL_T = 20;
    const CTRL_U = 21;
    const CTRL_V = 22;
    const CTRL_W = 23;
    const CTRL_X = 24;
    const CTRL_Y = 25;
    const CTRL_Z = 26;
    const A = 65;
    const a = 97;
    const ESC = 27;
    const TAB = 9;
    const ENTER = 10;
    const ONE = 49;
    const TWO = 50;
    const THREE = 51;
    const FOUR = 52;
    const FIVE = 53;
    const SIX = 54;
    const SEVEN = 55;
    const EIGHT = 56;
    const NINE = 57;
    const ZERO = 48;
    const TILDE = 96;
    const BANG = 33;
    const AT = 64;
    const HASH = 27;
    const DOLLA = 28;
    const PERCENT = 37;
    const HAT = 94;
    const AMP = 38;
    const STAR = 42;
    const PAREN_LEFT = 40;
    const PAREN_RIGHT = 41;
    const MINUS = 45;
    const PLUS = 43;
    const UNDERSCORE = 45;
    const EQUALS = 61;
    const BRACKET_SQ_LEFT = 91;
    const BRACKET_SQ_RIGHT = 93;
    const BRACKET_CURLY_LEFT = 123;
    const BRACKET_CURLY_RIGHT = 125;
    const BRACKET_ANGLE_LEFT = 60;
    const BRACKET_ANGLE_RIGHT = 62;
    const SEMI_COLON = 58;
    const COLON = 59;
    const QUOTE_SINGLE = 39;
    const QUOTE_DOUBLE = 34;
    const SLASH_BACK = 92;
    const SLASH = 47;
    const PIPE = 124;
    const COMMA = 44;
    const PERIOD = 46;
    const QUESTION = 63;
    const SPACE = 32;
    const ALT_A = [27, 97];
    const ALT_B = [27, 98];
    const ALT_C = [27, 99];
    const ALT_D = [27, 100];
    const ALT_E = [27, 101];
    const ALT_F = [27, 102];
    const ALT_G = [27, 103];
    const ALT_H = [27, 104];
    const ALT_I = [27, 105];
    const ALT_J = [27, 106];
    const ALT_K = [27, 107];
    const ALT_L = [27, 108];
    const ALT_M = [27, 109];
    const ALT_N = [27, 110];
    const ALT_O = [27, 111];
    const ALT_P = [27, 112];
    const ALT_Q = [27, 113];
    const ALT_R = [27, 114];
    const ALT_S = [27, 115];
    const ALT_T = [27, 116];
    const ALT_U = [27, 117];
    const ALT_V = [27, 118];
    const ALT_W = [27, 119];
    const ALT_X = [27, 120];
    const ALT_Y = [27, 121];
    const ALT_Z = [27, 122];

    public static function char($key) {
        return chr($key);
    }

}
