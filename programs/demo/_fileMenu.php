<?php

/**
 * @author John Snook
 * @date May 5, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */
use \tui\components\Style;
use \tui\elements\Button;
use \tui\elements\menu\Menu;
use \tui\elements\menu\MenuBar;
use \tui\elements\menu\MenuBarItem;
use \tui\elements\menu\Separator;
use Tui;
use \tui\helpers\Format;

/**
 * Description of _fileMenu
 */
return [
    'class' => MenuBar::className(),
    'css' => [
        'bgColor' => Format::xtermBgColor(248),
    ],
    'elements' => [
        'fileMenuItem' => [
            'class' => Button::className(),
            'css' => [
                'height' => 1,
                'paddingLeft' => 1,
                'paddingRight' => 1,
                'borderWidth' => Style::NONE,
                'borderStyle' => Style::NONE,
            ],
            'label' => '_File',
            'on click' => function ($data) {
                $menu = Tui::$program->menuBar->fileMenu;
                $menu->visible = !$menu->visible;
                if ($menu->visible) {
                    $menu->show();
                } else {
                    $menu->hide();
                }
            }
        ],
        'fileMenu' => [
            'class' => Menu::className(),
            'visible' => false,
            'css' => [
                'positioning' => Style::ABSOLUTE
            ],
            'elements' => [
                'newFile' => [
                    'class' => Button::className(),
                    'label' => '_New',
                    'on click' => function ($data) {
                        Tui::$program->statusBar->text = "New File";
                    }
                ],
                'openFile' => [
                    'class' => Button::className(),
                    'label' => '_Open',
                    'on click' => function ($data) {
                        Tui::$program->testWindow->open();
                    }
                ],
                'sep' => ['class' => Separator::className()],
                'quit' => [
                    'class' => Button::className(),
                    'label' => '_Quit',
                    'on click' => function () {
                        Tui::$program->end();
                    }
                ]
            ]
        ]
    ],
];
