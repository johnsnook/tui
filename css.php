<?php

/**
 * @author John Snook
 * @date May 10, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 * Like a default stylesheet or something
 * '*' refers to all elements, otherwise the class name is like a tag selector
 * A character byte on the screen is 1 pixel.  Regular numbers should be left unquoted
 * To specify percentage, use quotes and a '%', eg, '60%'.
 * 'auto' sizes things like buttons by their contents
 *
 *
 */
use \tui\helpers\Format;
use \tui\components\Style;

return[
    '*' => [
        /** @see helpers\Format */
        'bgPattern' => ' ',
        'bgColor' => Format::BG_GREY,
        'fgColor' => Format::FG_BLACK,
        'decoration' => Format::NORMAL,
        'paddingTop' => 0,
        'paddingRight' => 0,
        'paddingBottom' => 0,
        'paddingLeft' => 0,
        'marginTop' => 0,
        'marginRight' => 0,
        'marginBottom' => 0,
        'marginLeft' => 0,
        'positioning' => Style::ABSOLUTE,
    ],
    'Element' => [
        'positioning' => Style::RELATIVE,
    ],
    'Container' => [
        'positioning' => Style::ABSOLUTE,
    ],
    'Program' => [
        'bgColor' => Format::xtermBgColor(32),
        'width' => '100%',
        'height' => '100%',
    ],
    'MenuBar' => [
        'width' => '100%',
        'height' => 1,
        'paddingLeft' => 5,
        'align' => Style::TOP,
        'borderWidth' => Style::NONE,
    ],
//    'MenuBarItem' => [
//        'height' => 1,
//        'paddingLeft' => 1,
//        'paddingRight' => 1,
//        'borderWidth' => Style::NONE,
//        'borderStyle' => Style::NONE,
//    ],
    'Menu' => [
        'borderWidth' => Style::SINGLE,
    ],
    'StatusBar' => [
        'width' => '100%',
        'height' => 1,
        'paddingLeft' => 5,
        #'decoration' => Format::FRAMED,
        'positioning' => Style::ABSOLUTE,
        'align' => Style::BOTTOM
    ],
    'Button' => [
        'positioning' => Style::RELATIVE,
        'width' => Style::AUTO,
        'textAlign' => Style::CENTER,
        'height' => 3,
        'borderWidth' => Style::SINGLE,
        'borderStyle' => Style::OUTSET,
    ],
    'Window' => [
        'borderWidth' => Style::NONE,
    ],
    'Label' => [
        'textAlign' => Style::RIGHT,
        'height' => 1,
    ],
    'Border' => [
        'borderLitColor' => Format::xtermFgColor(253),
        'borderShadedColor' => Format::xtermFgColor(241),
    ]
];
