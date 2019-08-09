<?php

/**
 * @author John Snook
 * @date Apr 28, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace tui\elements;

use \tui\elements\Element;
use \tui\events\ElementEvent;
use \tui\helpers\Boxy;
use \tui\helpers\Rectangle;
use \Tui;
use \tui\base\InvalidCallException;
use \tui\base\UnknownPropertyException;

/**
 * {@inheritDoc }
 * Allows an Element to contain other elements in an elements array
 * @property Element[] $elements The elements to be displayed in this container
 * @property-read Rectangle $name Description
 */
class Container extends Element {

    /**
     * @var Elements[] The elements to be displayed in this container, stupid
     */
    protected $elements = [];

    /**
     * {@inheritDoc }
     * Initialize the elements in our elements array
     */
    public function init() {
        parent::init();
        //$this->style = new Style(['position' => Style::POSITION_ABSOLUTE]);
        $this->initializeElements();
        $this->applyStyleFlow();
    }

    /**
     * {@inheritdoc }
     * Then tell all our child elements to get ready.
     *
     * @return boolean Whether the container should be shown
     */
//    public function beforeShow() {
//        if (parent::beforeShow()) {
//            foreach ($this->pElements as $element) {
//                $element->show();
//            }
//            return true;
//        }
//        return false;
//    }

    /**
     * {@inheritDoc}
     *
     * Shows the container if it's not visible.  First it makes a copy of the owner
     * buffer where it will be displayed so it can be restored if this element
     * is hidden via it's [[hide()]] method.  If the item has any user defined events,
     * these are attached
     * Then tell all our child elements to show themselves.
     *
     * @param boolean $forceVisible
     * @return boolean Whether the container was shown
     */
    public function show($forceVisible = false) {
        if (parent::show($forceVisible)) {
            foreach ($this->elements as $element) {
                if ($element->show(true)) {
                    $element->afterShow();
                }
            }
            Tui::$observer->trigger(self::AFTER_SHOW_EVENT, new ElementEvent);
            return true;
        }
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function afterShow() {
        parent::afterShow();
        Tui::$observer->on(Container::AFTER_HIDE_EVENT, function($event) {
            /** if its me or I'm not visible, bail */
            if ($this === $event->sender || !$this->visible) {
                return;
            }
            if (Boxy::contains($this->absoluteRectangle, $event->sender->absoluteRectangle)) {
                $this->redraw($event->sender->absoluteRectangle);
            } elseif (Boxy::intersects($this->absoluteRectangle, $event->sender->absoluteRectangle)) {
                $interection = Boxy::intersection($event->sender->absoluteRectangle, $this->absoluteRectangle);
                $this->redraw($interection);
            } else {

            }
        });
    }

    /**
     * Sets visibility to false, detaches user events and restores the original
     * pixels of the owners buffer.
     * Then tell our elements to hide and detach their own events and let massa
     * know to refresh our rectangle
     */
    public function hide() {
        parent::hide();
        foreach ($this->elements as $element) {
            $element->hide();
        }
        Tui::$observer->trigger(self::AFTER_HIDE_EVENT, new ElementEvent(['sender' => $this]));
    }

    /**
     * The space available for drawing
     *
     * @return Rectangle
     */
    public function getInnerRectangle() {
        $b = ($this->style->borderWidth ? 1 : 0);
        $top = 1 + $this->style->paddingTop + $b;
        $y = 1 + $this->style->paddingLeft + $b;
        $height = $this->height - $this->style->padddingBottom - $b;
        $width = $this->width - $this->style->paddingRight - $b;
        return new Rectangle($top, $y, $height, $width);
    }

    /**
     * Setter for our element array
     * @param Element[] $elements
     */
    public function setElements($elements) {
        $this->elements = $elements;
    }

    /**
     * Getter for our element array
     * @return Element[]
     */
    public function getElements() {
        return $this->elements;
    }

    /**
     * Add an element to out element array
     * @param string $id
     * @param Element $element
     */
    public function addElement($id, Element $element) {
        $this->elements[$id] = $element;
    }

    /**
     * Removes an element from the element array
     * @param string $id The element array key
     */
    public function removeElement($id) {
        unset($this->elements[$id]);
    }

    /**
     * Returns the value of an object property.  If not found, it then checks
     * to see if an element in our elements array exists
     *
     * Overridding this method from parent tui/base/BaseObject to treat
     * Elements from the elements array as properties by Element->id
     *
     * Do not call this method directly as it is a PHP magic method that
     * will be implicitly called when executing `$value = $object->property;`.
     * @param string $name the property name
     * @return mixed the property value
     * @throws UnknownPropertyException if the property is not defined
     * @throws InvalidCallException if the property is write-only
     * @see __set()
     */
    public function __get($name) {
        try {
            return parent::__get($name);
        } catch (UnknownPropertyException $ex) {
            if (key_exists($name, $this->elements)) {
                return $this->elements[$name];
            }
            throw $ex;
        }
    }

    /**
     * Create and initialize our Elements
     */
    protected function initializeElements() {
        foreach ($this->elements as $id => $element) {
            if (is_array($element)) {
                $element['id'] = $id;
                $element['owner'] = $this;
                $element = \Tui::createObject($element);
                $this->elements[$id] = $element;
            } elseif ($element instanceof Element) {
                $this->addElement($id, $element);
                $element->id = $id;
                $element->owner = $this;
            }
        }
    }

    /**
     * At this stage, each of our elements has had it's style applied to it,
     * but if two items are both pulled left then they're overlapping.  This
     * method attempts to rectify that.  It relies entirely on the order of the
     * elements index in the array to establish precedence.
     */
    protected function applyStyleFlow() {
        $i = 0;
        foreach ($this->elements as $element) {
            if ($i === 0) {
                $i++;
                continue;
            }
        }
    }

}
