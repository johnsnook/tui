<?php

/**
 * @author John Snook
 * @date May 14, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace tui\elements;

use \tui\behaviors\RectangleBehavior;
use \tui\components\Style;
use \tui\helpers\Point;
use \tui\helpers\Dimensions;
use \tui\helpers\Rectangle;
use \tui\helpers\Screen;
use \tui\events\ElementEvent;
use \tui\events\ElementEvent;
use Tui;
use tui\base\Component;

/**
 * {@inheritDoc}
 * Provides the basics of a rectangle based component.  Also gets and mergers
 * css-like user data to all levels of inheritance, called class last.
 *
 * @property Style $style an object representing the formating options of this element
 * @property Point $absolutePosition An object with the x and y of this objects absolute position for rendering.
 */
class BaseElement extends Component {

    /**
     * @var string A hopefully unique name, mostly used by debugging really
     */
    public $id;

    /**
     * @var array  User defined style data
     */
    public $css;

    /**
     * @var boolean should only be set by show() or hide()
     */
    public $visible = FALSE;

    /**
     * @var Point The X & Y coordinates, relative to either screen or a Container
     */
    protected $pPosition;

    /**
     * @var Dimensions The width and height of this element
     */
    protected $pDimensions;

    /**
     * @var Style
     */
    protected $pStyle;

    /**
     * @var integer For debugging purposes
     */
    protected $pCounter = 0;

    /**
     * {@inheritDoc}
     * @param array $config name-value pairs that will be used to initialize the object properties
     */
    public function __construct($config = []) {
        $this->pPosition = new Point();
        $this->pDimensions = new Dimensions();
        parent::__construct($config);
    }

    /**
     * {@inheritDoc}
     * @staticvar int $counter
     */
    public function init() {
        parent::init();

        static $counter = 0;
        $this->pCounter = $counter++;

        /**
         * set the style property from the master css.php, and merge with any
         * custom settings
         */
        $this->pStyle = new Style(Tui::getStyle());

        /**
         * This should be called in any element that has its own css defined
         */
        $this->addClassStyle();
    }

    public function behaviors() {
        Debug::log($this);
        return [
            'rectangle' => RectangleBehavior::className()
        ];
    }

    /**
     * Dumb thing to track instance counts for debugging
     * @return integer
     */
    protected function getCounter() {
        return $this->pCounter;
    }

    /**
     * Returns the X (left) coordinate
     * @return integer
     */
    public function getX() {
        return $this->pPosition->left;
    }

    /**
     * Sets the X (left) coordinate
     * @param integer $val
     */
    public function setLeft($val) {
        $val = ($val < 1 ? 1 : $val);
        list($w, $h) = Screen::getSize();
        $val = ($val > $w ? $w : $val);
        if ($this->pPosition->left !== $val) {
            $old = $this->pPosition->left;
            $this->pPosition->left = $val;
            $event = new ElementEvent(['what' => 'x', 'new' => $val, 'old' => $old]);
            $this->trigger(ElementEvent::ELEMENT_MOVE_EVENT, $event);
        }
    }

    /**
     * Returns the Y (Top) coordinate
     * @return integer
     */
    public function getY() {
        return $this->pPosition->top;
    }

    /**
     * Sets the Y (Top) coordinate
     * @param integer $val
     */
    public function setTop($val) {
        $val = ($val < 1 ? 1 : $val);
        list($w, $h) = Screen::getSize();
        $val = ($val > $h ? $h : $val);

        if ($this->pPosition->top !== $val) {
            $old = $this->pPosition->top;
            $this->pPosition->top = $val;
            $event = new ElementEvent(['what' => 'y', 'new' => $val, 'old' => $old]);
            $this->trigger(ElementEvent::ELEMENT_MOVE_EVENT, $event);
        }
    }

    /**
     * @return Point
     */
    public function getPosition() {
        return $this->pPosition;
    }

    /**
     * Returns the height dimension
     * @return integer
     */
    public function getHeight() {
        return $this->pDimensions->height;
    }

    /**
     * Sets the height dimension
     * @param integer $val
     */
    public function setHeight($val) {
        if ($this->pDimensions->height != $val) {
            $val = ($val < 1 ? 1 : $val);
            $val = ($val > Screen::$height ? Screen::$height : $val);

            $old = $this->pDimensions->height;
            $this->pDimensions->height = $val;
            $event = new ElementEvent(['what' => 'height', 'new' => $val, 'old' => $old]);
            $this->trigger(ElementEvent::ELEMENT_RESIZE_EVENT, $event);
        }
    }

    /**
     * Returns the width dimension
     * @return integer
     */
    public function getWidth() {
        return $this->pDimensions->width;
    }

    /**
     * Sets the width dimension
     * @param integer $val
     */
    public function setWidth($val) {
        if ($this->pDimensions->width != $val) {
            $val = ($val < 1 ? 1 : $val);
            $val = ($val > Screen::$width ? Screen::$width : $val);

            $old = $this->pDimensions->width;
            $this->pDimensions->width = $val;
            $event = new ElementEvent(['what' => 'width', 'new' => $val, 'old' => $old]);
            $this->trigger(ElementEvent::ELEMENT_RESIZE_EVENT, $event);
        }
    }

    /**
     * @return Dimensions
     */
    public function getDimensions() {
        return $this->pDimensions;
    }

    /**
     * The Style object property
     * @return Style
     */
    public function getStyle() {
        return $this->pStyle;
    }

    /**
     * Moves the element top left corner to the coordinate
     * @param integer $y
     * @param integer $x
     */
    public function move($y, $x) {
        $old = clone $this->pPosition;
        $this->pPosition->top = (($y + $this->height ) > Tui::$observer->height ? Tui::$observer->height - $this->height : ($y < 1 ? 1 : $y));
        $this->pPosition->left = (($x + $this->width) > Tui::$observer->width ? Tui::$observer->width - $this->width + 1 : ($x < 1 ? 1 : $x));

        $event = new ElementEvent(['what' => 'position', 'new' => $this->pPosition, 'old' => $old]);
        $this->trigger(ElementEvent::ELEMENT_MOVE_EVENT, $event);
    }

    /**
     * Sets the dimensions of this element
     * @param integer $height
     * @param integer $width
     */
    public function resize($height = null, $width = null) {
        $old = clone $this->pDimensions;
        $this->height = $height;
        $this->width = $width;
        $event = new ElementEvent(['what' => 'dimensions', 'new' => $this->pDimensions, 'old' => $old]);
        $this->trigger(ElementEvent::ELEMENT_RESIZE_EVENT, $event);
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
            return $this->position;
        } elseif ($this->style->positioning === Style::RELATIVE) {
            $element = $this;
            $absolut = clone $this->position;
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
    }

    /**
     * Calculates and returns an rectangles relative to the y x of the screen
     * @return Point
     */
    public function getAbsoluteRectangle() {
        $pos = $this->absolutePosition;
        return new Rectangle($pos->left, $pos->top, $this->width, $this->height);
    }

}
