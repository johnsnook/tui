<?php

/**
 * @author John Snook
 * @date May 2, 2019
 * @license https://snooky.biz/site/license
 * @copyright 2019 John Snook Consulting
 * Description of window
 */
use \tui\components\Style;
use \tui\elements\Button;
use \tui\elements\Program;
use \tui\elements\window\Window;
use \tui\helpers\Keys;
use \tui\helpers\Format;

#use Tui;

/**
 * Sample Tui Application
 */
return new Program([
    'id' => 'demo',
    'css' => [
        'bgColor' => Format::xtermBgColor(93),
        'fgColor' => Format::xtermFgColor(21),
        #'bgPattern' => '  ░░▒▒▓▓▒▒░░'
        #'bgPattern' => ' ░▒▓▒░'
        'bgPattern' => '░'
    ],
    'on ready' => function($event) {
        $event->sender->testWindow->open();
    },
//    'observerConfig' => [
//        'on *' => function($event) {
//            $sb = Tui::$program->statusBar;
//            if (is_a($event, KeyPressEvent::className())) {
//                $sb->changeText($event->description);
//            } elseif (is_a($event, MouseEvent::className())) {
//                $sb->changeText($event->name . " X: {$event->point->left} Y: {$event->point->top}");
//            } else {
//                #$sb->changeText($event->name);
//            }
//        }
//    ],
    'exitKey' => Keys::CTRL_Q,
    'elements' => [
        'testWindow' => [
            'class' => Window::className(),
            'title' => 'Test Window',
            'css' => [
                'bgColor' => Format::xtermBgColor(248),
                'align' => Style::VERTICAL + Style::HORIZONTAL,
                'width' => '50%',
                'height' => '50%',
                'borderWidth' => Style::SINGLE,
            ],
            'elements' => [
                'btnClose' => [
                    'class' => Button::className(),
                    'label' => '_Close',
                    'on click' => function($event) {
                        $event->sender->owner->close();
                    },
                    'css' => [
                        'bgColor' => Format::xtermBgColor(248),
                        'fgColor' => Format::FG_BLACK,
                        //'decoration' => Format::BOLD,
                        'width' => 12,
                        'height' => 3,
                        'marginBottom' => 2,
                        'align' => Style::HORIZONTAL + Style::BOTTOM,
                    ]
                ]
            ]
        ]
    ]]
);


