<?php

namespace tui\controllers;

use \tui\helpers\Format;
use \tui\Tui;
use \tui\components\Observer;

/**
 * @Author John Snook
 * @date Apr 29, 2018
 * @License https://snooky.biz/site/license
 * @Copyright 2018 John Snook Consulting
 */
class TuiController extends \tui\console\Controller {

    public function init() {
        parent::init();
        \Tui::setAlias('@tui', __DIR__ . '/..');
    }

    public function actionIndex() {
        Tui::$observer = Observer::getInstance();
        Tui::$styleSheet = require \Tui::getAlias('@tui/css.php');
        Tui::$program = require \Tui::getAlias('@tui/programs/demo/main.php');
        $exitCode = Tui::$program->run();
        exit($exitCode);
    }

    public function actionTest() {
        $esc = "\033";
        echo "{$esc} P p p[384,240] c[+100,+50] {$esc}\\";
    }

    public function actionColors() {
        for ($i = 0; $i < 15; $i++) {
            echo Format::ansi($i, [Format::xtermFgColor($i)]) . ' ';
        }
        echo PHP_EOL;
        for ($i = 0; $i < 15; $i++) {
            echo Format::ansi($i, [Format::NEGATIVE, Format::xtermFgColor($i)]) . ' ';
        }
        echo PHP_EOL;
        for ($i = 0; $i < 15; $i++) {
            echo Format::ansi($i, [Format::ITALIC, Format::xtermFgColor($i)]) . ' ';
        }
        echo PHP_EOL;
        for ($i = 0; $i < 15; $i++) {
            echo Format::ansi($i, [Format::CONCEALED, Format::xtermFgColor($i)]) . ' ';
        }
        echo PHP_EOL;
        for ($i = 0; $i < 15; $i++) {
            echo Format::ansi($i, [Format::FRAMED, Format::xtermFgColor($i)]) . ' ';
        }
        echo PHP_EOL;

//        for ($i = 0; $i < 15; $i++) {
//            echo Format::ansi($i, [Format::xtermBgColor($i)]) . ' ';
//        }
//        echo PHP_EOL;
//        for ($i = 0; $i < 15; $i++) {
//            echo Format::ansi($i, [Format::BOLD, Format::xtermBgColor($i)]) . ' ';
//        }
//        echo PHP_EOL;

        for ($i = 16; $i < 256; $i++) {
            echo Format::ansi(str_pad($i, 3), [Format::xtermFgColor($i)]) . ' ';
            if ((($i + 3) % 6) === 0)
                echo PHP_EOL;
        }
        echo PHP_EOL;
        for ($i = 16; $i < 256; $i++) {
            echo Format::ansi(str_pad($i, 3), [Format::xtermBgColor($i)]) . ' ';
            if ((($i + 3) % 6) === 0)
                echo PHP_EOL;
        }
        echo PHP_EOL;

        //Tui::$observer->mainLoop();
    }

    public function actionColors2() {
        $esc = "\033]";
        for ($i = 0; $i < hexdec("FFFFFFF"); $i++) {
            $hexStr = str_pad(dechex($i), 7, '0', STR_PAD_LEFT);
            $arr = str_split($hexStr);
            echo '/' . dechex($i) . "/ [C:{$arr[0]}, R:{$arr[1]}{$arr[2]}, G:{$arr[3]}{$arr[4]}, B:{$arr[5]}{$arr[6]}]";
            echo "{$esc}P{$hexStr}";
            echo $hexStr;
            echo "{$esc}R\n";
        }
        echo PHP_EOL;

        //Tui::$observer->mainLoop();
    }

    public function actionBuffer() {
        $buffer = new \tui\components\Rectangle([
            'type' => Buffer::TYPE_ROUND,
            'width' => 30,
            'height' => 10
        ]);
        $top = 10;
        $y = 60;

        $ent = $buffer->makeBuffer();
        foreach ($ent as $row => $line) {
            Console::moveCursorTo($y, $top + $row);
            echo $line;
        }
        Tui::$observer->mainLoop();
    }

}
