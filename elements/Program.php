<?php

namespace tui\elements;

//use \tui\helpers\Console;
use \tui\components\Observer;
//use \tui\elements\Container;
use \tui\events\KeyPressEvent;
use \tui\events\ScreenResizeEvent;
use \tui\helpers\Screen;
use \tui\helpers\Cursor;
use \tui\helpers\Debug;
use \tui\helpers\Keys;
use Tui;
use tui\base\ExitException;

/**
 * @author John Snook
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 *
 * Singleton-ishly encapsulates a tui Program
 */
class Program extends \tui\elements\Container {

    public $exitKey = Keys::ESC;

    /**
     * @var Closure holds a user defined closure to be run once the program
     * and all it's elements have been initialized
     */
    #public $ready;

    /**
     * @var integer $gridWidth The bootstrap-ish layout columns
     */
    public $gridWidth = 12;

    /**
     * @var integer $gridHeight The bootstrap-ish layout columns
     */
    public $gridHeight = 4;
    public $observerConfig;

    /**
     * @var boolean Half-assed exit code
     */
    private $statusGood = false;

    /**
     * {@inheritDoc }
     */
    public function init() {
        $d = new \DateTime;
        Debug::log($this, $d->format('Y-m-d H:i'));
        parent::init();
        Cursor::hide();
        Tui::configure(Tui::$observer, $this->observerConfig);

        Tui::$observer->exitKey = $this->exitKey;
        Tui::$observer->on(Observer::SCREEN_RESIZE, function (ScreenResizeEvent $event) {
            $this->resize($event->height, $event->width);
            $this->refresh();
            $this->statusBar->text = "Resized!";
        });
        Tui::$observer->on(Observer::KEY_PRESSED, function (KeyPressEvent $event) {
            if ($event->description === 'CTRL-q') {
                $this->end();
                $event->handled = true;
            } elseif ($event->description === 'CTRL-l') {
                $this->refresh();
                $event->handled = true;
            }
        });
    }

//    public function show($forceVisible = false) {
//        Debug::log($this, (string) $this);
//        parent::show();
//    }

    /**
     * Starts the [[mainLoop]] in [[Observer]] and cleans up after.
     *
     * @return integer The status code
     */
    public function run() {
        try {
            $this->show();
            Debug::log($this, 'calling mainloop');
            Tui::$observer->mainLoop();
            $this->statusGood = TRUE;
            Debug::log($this, 'Happy ending!');
        } catch (ExitException $e) {
            Debug::log($this, $e);
            $this->end($e->statusCode);
            return $e->statusCode;
        }
    }

    /**
     * Ends the program by telling the observer to break it's loop
     */
    public function end($exitCode = 0) {
        #$this->hide();
        Tui::$observer->stop();
    }

    /**
     *
     * Clean up time, and there's a fair amount, mostly handled by the
     * Observer::__destruct.
     * Clear the screen, and un-hide the cursor
     */
    public function __destruct() {
        Debug::log($this, 'EOT');

        if ($this->statusGood) {
            Cursor::moveTo($this->width, $this->height);
            Screen::clearBeforeCursor();
            Cursor::pageUp();
            #Screen::clear();
        }
        Cursor::moveTo($this->left, $this->top);
        Cursor::show();
    }

    private function refresh() {
        Cursor::moveTo($this->width, $this->height);
        Screen::clearBeforeCursor();
        $this->hide();
        $this->show();
    }

}
