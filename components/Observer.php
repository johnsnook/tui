<?php

/**
 * @author John Snook
 * @date Apr 30, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 * @see https://stackoverflow.com/questions/5966903/how-to-get-mousemove-and-mouseclick-in-bash
 * @see https://www.csie.ntu.edu.tw/~r92094/c++/VT100.html
 */

namespace tui\components;

use \tui\events\KeyPressEvent;
use \tui\events\MouseEvent;
use \tui\events\ScreenResizeEvent;
use \tui\helpers\Keys;
use \tui\helpers\Screen;
use tui\base\Component;

/**
 * The observer listens for key presses and mouse events and publishes the events
 * to listening objects
 *
 * In classic console tui applications, we have to provide our own "main loop"
 * to check for key presses or mouse clicks.  This class provides the following:
 * 1) The event listening loop - mainLoop()
 * 2) Complex event analysis
 * 3) Event processing
 * 4) Event propagation
 *
 * @property string $exitKey They key that will always interrupt the main loop
 * @property float $sleepTime The fraction of a second to sleep in our loop
 * @property integer $height The screen height
 * @property integer $width The screen width
 *
 * @see https://stackoverflow.com/questions/5966903/how-to-get-mousemove-and-mouseclick-in-bash
 * @see https://www.csie.ntu.edu.tw/~r92094/c++/VT100.html
 */
class Observer extends Component {

    /** @event ScreenResizeEvent The screen size has changed */
    const SCREEN_RESIZE = 'ScreenResize';
    const KEY_PRESSED = 'keypress';
    const MOUSE_LEFT_DOWN = 'LeftDown';
    const MOUSE_LEFT_UP = 'LeftUp';
    const MOUSE_MIDDLE_DOWN = 'MiddleDown';
    const MOUSE_MIDDLE_UP = 'MiddleUp';
    const MOUSE_RIGHT_DOWN = 'RightDown';
    const MOUSE_RIGHT_UP = 'RightUp';
    const MOUSE_SCROLL_DOWN = 'ScrollDown';
    const MOUSE_SCROLL_UP = 'ScrollUp';

    static private $instance = null;

    /**
     * @var int The key that ends the loop
     */
    public $exitKey = Keys::ESC;

    /**
     * @var float The time in seconds to sleep and allow the system to process
     * other events
     */
    public $sleepTime = .1;

    /**
     * @var string The stty -g settings to restore
     */
    private $term;

    /**
     * @var integer The screen width, the last time we checked, and we check
     * often
     */
    private $width = 10;

    /**
     * @var integer The screen height, the last time we checked, and we check
     * often
     */
    private $height = 10;

    /**
     * @var boolean Set to true by Observer::stop() and if true, breaks the main loop
     */
    private $stopped = false;

    /**
     * @return Observer Returns a singleton instance of this object
     */
    static public function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Save the terminal settings, then turn off echo and turn off
     * line editing mode
     *
     * @see https://blog.nelhage.com/2009/12/a-brief-introduction-to-termios-termios3-and-stty/
     *
     * @param array $config The configuration array.
     */
    public function __construct($config = []) {
        parent::__construct($config);
        /** Save terminal settings before getting into Tui mode */
        $this->term = `stty -g`;
        $this->term = substr($this->term, 0, strlen($this->term) - 1);
        system("stty -icanon -echo -ixon -isig ");
        #system("stty -icanon -echo -echoe -echok -echonl -echoctl -isig -ixon -ignbrk -brkint");
        /** send codes to listen for mouse events */
        echo "\e[?1000h";
        echo "\e[?1015h";
        echo "\e[?1006h";

        list($this->width, $this->height) = Screen::getSize();
    }

    /**
     * Main listen loop.  Read up to 12 bytes from STDIN, then based on the number
     * of bytes we know whether it's a keypress or mouse event. The KeyEvent
     * will parse the
     */
    public function mainLoop() {
        /** Turn off blocking so we can do other stuff */
        stream_set_blocking(STDIN, false);
        while ((($inputChars = fread(STDIN, 64)) !== $this->exitKey) && !$this->stopped) {
            if (!empty($inputChars)) {
                $this->logJammin($inputChars);
            }
            $this->tock();

            /**
             * take the sleeptime, separate the integer part, and multiply it by
             * about a billion
             */
            $sleepyTime = $this->sleepTime;
            if ($intPart = intval($sleepyTime)) {
                $sleepyTime -= $intPart;
            }
            $sleepyTime *= 1000000000;
            time_nanosleep($intPart, $sleepyTime);
        }
    }

    /**
     * For parsing big, full buffers of unprocessed events in the event of lag
     * using the best regex pattern I've ever made.  If anyone ever reads this
     * and is actually good at regex, please feel free to critique it; I can always
     * use good advice.  Once the data has been parsed into the array $keyLog,
     * iterate and trigger each event
     *
     * @param string $input The input buffer
     */
    private function logJammin($input) {
        $keyLog = [];
        $pattern = "/(\e(\[((<\d+;\d+;\d+m)|(\d;\d\S)|(\d\S)|(\w+))|.)|.)|(.)/mi";
        preg_match_all($pattern, $input, $keyLog, PREG_OFFSET_CAPTURE);
        foreach ($keyLog[0] as $match) {
            $inputChars = $match[0];
            $inputLength = strlen($inputChars);
            if ($inputLength > 0 && $inputLength <= 6) { // Key events are 6 or less bytes
                $event = new KeyPressEvent(['rawData' => $inputChars]);
                $this->trigger($event->name, $event);
            } elseif ($inputLength > 6) { // Key events are more than 6 bytes
                $event = new MouseEvent(['rawData' => $inputChars]);
                $this->trigger($event->name, $event);
            }
        }
    }

    /**
     * Checks to see if the screen has resized.  May be used to watch for other
     * events if I think of any.  Actually, a user defined callable is just the
     * ticket
     * @param Observer $me
     */
    private function tock() {
        $w = $h = 0;
        list($w, $h) = Screen::getSize(true);
        if ($this->width !== $w || $this->height !== $h) {
            $this->height = $h;
            $this->width = $w;
            $event = new ScreenResizeEvent(['width' => $w, 'height' => $h]);
            $this->trigger(self::SCREEN_RESIZE, $event);
        }
    }

    /**
     * Allows other user to interrupt the loop externally
     */
    public function stop() {
        $this->stopped = true;
    }

    /**
     * @return integer Screen height
     */
    public function getHeight() {
        return $this->height;
    }

    /**
     * @return integer Screen width
     */
    public function getWidth() {
        return $this->width;
    }

    /**
     * Restore the terminal settings
     */
    public function __destruct() {
        echo "\e[?1000l";
        system("stty '" . $this->term . "'");
    }

}
