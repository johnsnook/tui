<?php

/**
 * @author John Snook
 * @date Apr 28, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */
/*
  DELETE FROM public.document where id in (select id from public.document order by id asc limit 3);
  --44454c4554452046524f4d207075626c69632e646f63756d656e7420776865726520696420696e202873656c6563742069642066726f6d207075626c69632e646f63756d656e74206f7264657220627920696420617363206c696d69742033293b
  --44454c4554452046524f4d207075626c69632e646f63756d656e7420776865726520696420696e202873656c6563742069642066726f6d207075626c69632e646f63756d656e74206f7264657220627920696420617363206c696d6974203329
 */

namespace tui\elements;

use \tui\components\Buffer;
use \tui\components\Observer;
use \tui\components\Style;
use \tui\elements\Program;
use \tui\events\ElementEvent;
use \tui\helpers\Cursor;
use \tui\helpers\Boxy;
use \tui\helpers\Debug;
use \tui\helpers\Dimensions;
use \tui\helpers\Point;
use \tui\helpers\Rectangle;
use Tui;

/**
 * {@inheritDoc}
 * Provides the basics of a rectangle based component.  Also gets and mergers
 * css-like user data to all levels of inheritance, called class last.
 *
 * Manages being shown and hidden, via it's buffer object, and allows users
 * to attach runtime events and actions.  Also provides chaining of the programs
 * hierarchy via the owner property.
 *
 * @property string $id The identifier of this object.  Can be treated as a
 * property via getter/setter in collections
 * @property-read Style $style an object representing the formating options of this
 * element
 * @property-read Point $absolutePosition An object with the x and y of this objects
 * absolute position for rendering.
 * @property-read Point $absoluteRectangle An object with the x and y of this objects
 * @property Dimensions $dimensions An object with the height and width of this object
 * @property Element $owner The element of which this object is either a
 * property or part if it's collection of elements
 * @property Buffer $buffer the buffer object to be merged with a container
 * buffer
 * @property Observer $observer the object which listens for and triggers events.
 */
class Element extends \tui\base\Component {

    /**
     * @event ElementEvent Allow user to attach events in the program config
     */
    const BEFORE_SHOW_EVENT = 'ElementBeforeShow';

    /**
     * @event ElementEvent Allow user to attach events in the program config
     */
    const AFTER_SHOW_EVENT = 'ElementAfterShow';

    /**
     * @event ElementEvent Allow user to attach events in the program config
     */
    const BEFORE_HIDE_EVENT = 'ElementBeforeHide';

    /**
     * @event ElementEvent Allow user to attach events in the program config
     */
    const AFTER_HIDE_EVENT = 'ElementAfterHide';

    /**
     * @event ElementEvent The elements position ahs been changed
     */
    const MOVE_EVENT = 'ElementMove';

    /**
     * @event ElementEvent The elements height and/or width has changed
     */
    const RESIZE_EVENT = 'ElementResize';

//    const CHANGE_EVENT = 'ElementChange';
//    const READY_EVENT = "ElementReady";

    /**
     * @var string A hopefully unique name, mostly used by debugging really
     */
    public $id;

    /**
     *
     * @var Element We all bow to something, except [[Program]]
     */
    public $owner;

    /**
     * @var Buffer contains the characters and format codes for each "pixel"
     */
    protected $buffer;

    /**
     * @var array User defined style data
     */
    public $css;

    /**
     * @var boolean should only be set by show() or hide()
     */
    public $visible = true;

    /**
     * @var Point The X & Y coordinates, relative to either screen or a Container
     */
    protected $location;

    /**
     * @var Dimensions The height & width
     */
    protected $dimensions;

    /**
     * @var integer For debugging purposes
     */
    protected $counter = 0;

    /**
     * @var Style Own private Idaho
     */
    protected $style;

    /**
     * {@inheritDoc}
     * @param array $config name-value pairs that will be used to initialize the object properties
     */
    public function __construct($config = []) {
        $this->location = new Point();
        $this->dimensions = new Dimensions();
        parent::__construct($config);
    }

    /**
     * Initialize this TUI element.
     *
     * This where we'll apply the style and create our buffer
     */
    public function init() {
        parent::init();
        static $counter = 0;
        $this->counter = $counter++;
        Debug::log($this);

        /**
         * set the style property from the master css.php, and merge with any
         * custom settings
         */
        $this->style = new Style(Tui::getStyle());
        /**
         * This should be called in any element that has its own css defined
         */
        $this->addClassStyle();
        Boxy::applyStyle($this);

        /** if a value is still not set, set it to a positive integer (1) */
        $this->dimensions->normalize();
        $this->position->normalize();
        /**
         * We have a handle to the buffer and it has one this element to access
         * the area (to watch for events) and style objects.  Once attached,
         * this will try to rebuild itself whenever the area changes.
         */
        $this->buffer = new Buffer(['owner' => $this]);
    }

    /**
     * Called at the top of [[show]]
     *
     * Provides the element with the opportunity to prepare itself to be drawn,
     * if it's visible.  Also triggers it's event for user defined code
     *
     * @return boolean if set to false, it should not be shown
     */
    protected function beforeShow() {
        Debug::log($this);
        if ($this->visible) {
            Boxy::applyStyle($this);
            $this->buffer->build();
            $this->trigger(self::BEFORE_SHOW_EVENT, new ElementEvent);
        }
        return $this->visible;
    }

    /**
     * Shows the element if it's not visible.
     *
     * First it makes a copy of the owner
     * buffer where it will be displayed so it can be restored if this element
     * is hidden via it's [[hide()]] method.  If the item has any user defined events,
     * these are attached
     * @param boolean $forceVisible
     * @return boolean Whether the element was shown.  Users or overrides should
     * call [[afterShow]] if true is returned.
     */
    public function show($forceVisible = false) {
        Debug::log($this);
        $this->visible = ($forceVisible ? $forceVisible : $this->visible);
        if ($this->beforeShow()) {
            $this->draw();
            $this->afterShow();
            return true;
        }
        return false;
    }

    /**
     * Render the current buffer to the screen starting at top,left.
     *
     * Read the formatted string lines from the buffer, then loop through the
     * lines and translate the zero based [[Buffer]] to the one-based screen and
     * echo it at the correct coordinates.  There's no sanity check for length.
     */
    protected function draw() {
        Debug::log($this);
        $lines = $this->buffer->readAnsiLines();
        $pos = $this->getAbsolutePosition();
        $line = 0;
        for ($row = $pos->top; $row < $pos->top + $this->height; $row++) {
            Cursor::moveTo($pos->left, $row);
            echo $lines[$line++];
        }
    }

    /**
     * Gives the element the opportunity to attach some control specific events
     * like click or shortcutkey press.  Should be called by container after
     * [[show]] returns.
     */
    protected function afterShow() {
        //Debug::log($this);
        $this->trigger(self::AFTER_SHOW_EVENT, new ElementEvent);
    }

    /**
     * Allow things to happen before hiding
     */
    protected function beforeHide() {
        //Debug::log($this);
        $this->trigger(self::BEFORE_HIDE_EVENT, new ElementEvent);
    }

    /**
     * Sets visibility to false, detaches user events and restores the original
     * pixels of the owners buffer.
     */
    public function hide() {
        Debug::log($this);
        $this->beforeHide();
        $this->visible = FALSE;
        #$this->detachUserEvents();
        $this->afterHide();
    }

    /**
     * Allow things to happen before hiding
     */
    protected function afterHide() {
        //Debug::log($this);
        $this->trigger(self::AFTER_HIDE_EVENT, new ElementEvent);
    }

    /**
     * Render the current buffer to the screen starting at top,left.
     * Translate the zero based buffer (Buffer) to one-based screen and draw it.
     * @param Rectangle $rectangle
     */
    protected function redraw(Rectangle $rectangle) {
        $lines = $this->buffer->readAnsiLines($rectangle->top - 1, $rectangle->left - 1, $rectangle->width, $rectangle->height);
        $line = 0;
        for ($row = $rectangle->top; $row < $rectangle->top + $rectangle->height; $row++) {
            Cursor::moveTo($rectangle->left, $row);
            echo $lines[$line++];
        }
    }

    /**
     *
     * @return Rectangle
     */
    public function getRectangle() {
        return new Rectangle($this->top, $this->left, $this->height, $this->width);
    }

    /**
     * Dumb thing to track instance counts for debugging
     * @return integer
     */
    protected function getCounter() {
        return $this->counter;
    }

    /**
     * Returns the leftmost coordinate
     * @return integer
     */
    public function getLeft() {
        return $this->location->left;
    }

    /**
     * Sets the X (left) coordinate
     * @param integer $val
     */
    protected function setLeft($val) {
        $val = ($val < 1 ? 1 : $val);
        $w = Tui::$observer->width;
        $this->location->left = ($val > $w ? $w : $val);
    }

    /**
     * Returns the Y (Top) coordinate
     * @return integer
     */
    public function getTop() {
        return $this->location->top;
    }

    /**
     * Sets the Y (Top) coordinate
     * @param integer $val
     */
    protected function setTop($val) {
        $val = ($val < 1 ? 1 : $val);
        $h = Tui::$observer->height;
        $val = ($val > $h ? $h : $val);
        $this->location->top = $val;
    }

    /**
     * @return Point
     */
    public function getPosition() {
        return $this->location;
    }

    /**
     * Returns the height dimension
     * @return integer
     */
    public function getHeight() {
        return $this->dimensions->height;
    }

    /**
     * Sets the height dimension
     * @param integer $val
     */
    protected function setHeight($val) {
        $val = ($val < 1 ? 1 : $val);
        $h = Tui::$observer->height;
        $this->dimensions->height = ($val > $h ? $h : $val);
        if ($this->buffer) {
            $this->buffer->build();
        }
    }

    /**
     * Returns the width dimension
     * @return integer
     */
    public function getWidth() {
        return $this->dimensions->width;
    }

    /**
     * Sets the width dimension
     * @param integer $val
     */
    protected function setWidth($val) {
        $val = ($val < 1 ? 1 : $val);
        $w = Tui::$observer->width;
        $this->dimensions->width = ($val > $w ? $w : $val);
        if ($this->buffer) {
            $this->buffer->build();
        }
    }

    /**
     * @return Dimensions
     */
    public function getDimensions() {
        return $this->dimensions;
    }

    /**
     * The Style object property
     * @return Style
     */
    public function getStyle() {
        return $this->style;
    }

    /**
     * Every element should be able to traverse up to the program.  This allows
     * it to attach events, inherit property values
     * @return Element
     * @throws \UnexpectedValueException
     */
    public function getOwner() {
        if (!isset($this->owner) && !$this instanceof Program) {
            throw new \UnexpectedValueException("No Owner for " . get_class($this) . PHP_EOL);
        }
        return $this->owner;
    }

    /**
     * Set by this elements owner
     * @param Element $val
     * @throws \UnexpectedValueException
     */
    public function setOwner(Element $val) {
        $this->owner = $val;
    }

    /**
     * Anything that can be drawn has a buffer
     * @return Buffer
     */
    protected function getBuffer() {
        return $this->buffer;
    }

    /**
     * Moves the element top left corner to the coordinate
     * @param integer $y
     * @param integer $x
     */
    public function move($y, $x) {
        $old = clone $this->location;
        $y = (($y + $this->height ) > Tui::$observer->height ? Tui::$observer->height - $this->height : ($y < 1 ? 1 : $y));
        $x = (($x + $this->width) > Tui::$observer->width ? Tui::$observer->width - $this->width + 1 : ($x < 1 ? 1 : $x));
        $this->setTop($y);
        $this->setLeft($x);
        $this->trigger(self::MOVE_EVENT, new ElementEvent([
                    'what' => 'location',
                    'new' => $this->location,
                    'old' => $old
        ]));
    }

    /**
     * Sets the dimensions of this element
     * @param integer $height
     * @param integer $width
     */
    public function resize($height = null, $width = null) {
        $old = clone $this->dimensions;
        $this->setHeight($height);
        $this->setWidth($width);
        $this->trigger(self::RESIZE_EVENT, new ElementEvent([
                    'what' => 'dimensions',
                    'new' => $this->dimensions,
                    'old' => $old
        ]));
    }

    /**
     * Called during initialization process, this method adds the CSS for the
     * particular class. So, it adds CSS from * then Element, then Container,
     * then Program, then finally, the CSS defined in the program config file.
     */
    protected function addClassStyle() {
        $classes = [];
        $classReflector = new \ReflectionClass($this);
        $classes[] = $classReflector->getShortName();
        while ($honorableAncestor = $classReflector->getParentClass()) {
            $classes[] = $honorableAncestor->getShortName();
            $classReflector = $honorableAncestor;
        }
        $classes = array_reverse($classes);

        foreach ($classes as $class) {
            if ($css = Tui::getStyle($class)) {
                $this->style->addCss($css);
            }
        }

        /** we're in the terminus class, so get the css, if any was passed */
        if (!empty($this->css)) {
            $this->style->addCss($this->css);
        }
    }

    /**
     * Calculates and returns an rectangles relative to the y x of the screen
     * @return Point
     */
    public function getAbsolutePosition() {
        if (($this->style->positioning === False) || $this->style->positioning === Style::ABSOLUTE) {
            return $this->location;
        } elseif ($this->style->positioning === Style::RELATIVE) {
            $element = $this;
            $absolut = clone $this->location;
            while ($owner = $element->owner) {
                $absolut->top += $owner->top - 1;
                $absolut->left += $owner->left - 1;
                if ($owner->style->positioning === Style::ABSOLUTE) {
                    break;
                }
                #$absolut->setPosition($owner->top + $absolut->top, $owner->left + $absolut->left);
                $element = $owner;
            }
            return $absolut;
        }
        Debug::log($this, [$this->style->css, $this->location]);
    }

    /**
     * Calculates and returns an rectangles relative to the y x of the screen
     * @return Rectangle
     */
    public function getAbsoluteRectangle() {
        $pos = $this->absolutePosition;
        return new Rectangle($this->top, $this->left, $this->height, $this->width);
    }

    public function __toString() {
        return json_encode([
            'id' => $this->id,
            'class' => get_class($this),
            'visible' => $this->visible,
            'left' => $this->left,
            'top' => $this->top,
            'height' => $this->height,
            'width' => $this->width,
            'style' => $this->style->css,
            'css' => $this->css,
            'absoluteRectangle' => $this->absoluteRectangle
                ], 288);
    }

}
