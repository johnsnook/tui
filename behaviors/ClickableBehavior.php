<?php

/**
 * @author John Snook
 * @date Apr 28, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace tui\behaviors;

use \tui\components\Style;
use \tui\components\Observer;
use \tui\events\ControlEvent;
use \tui\elements\Element;
use \tui\events\KeyPressEvent;
use \tui\events\MouseEvent;
use tui\helpers\Debug;
use Tui;

/**
 * Signals interest in and provides method for ClickEvents
 *
 * Provides the events, properties and methods to make an element respond to
 * clicks.
 */
class ClickableBehavior extends ControlBehavior {

    /**
     * @event MouseEvent|KeyPressEvent "Clicks" can be triggered by either clicking
     * with the mouse or using the keyboard shortcut.
     */
    const CLICK_EVENT = 'click';

    /**
     * set to '' for things like drop down menus?
     */
    public $keyModifier = 'ALT-';

    /**
     * this should contain a \\tui\components\Style Pen string.
     */
    public $shortcutKeyDecorator;

    /**
     * @Description To use, declare a KeyPressEvent with the settings you're interested in
     * @var \tui\events\KeyPressEvent
     */
    public $shortcutKey = '';

    public function events() {
        return [
            Element::BEFORE_SHOW_EVENT => 'beforeShow',
            Element::AFTER_SHOW_EVENT => 'afterShow',
            Element::AFTER_HIDE_EVENT => 'afterHide',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function beforeShow($event) {
#        $this->owner->width += $this->labelLength;
        //$this->bufferLabel();
    }

    /**
     * We care about 3 kinds of events: key press, mouse down and mouse up.  It's
     * not a proper click unless the mouse down and mouse up occur within our rectangle.
     *
     * We really only care about mouse up events after a mouse down happens in our
     * rectangle, so we reserve attaching a listener for mouse up until after the
     * mouse down event.
     */
    public function afterShow($event) {
        Tui::$observer->on(Observer::KEY_PRESSED, [$this, 'keypressHandler']);
        Tui::$observer->on(Observer::MOUSE_LEFT_DOWN, [$this, 'mouseDownHandler']);
    }

    /**
     * Detaches the event which were attached in [[attachEvents]]
     */
    public function afterHide($event) {
        Tui::$observer->off(Observer::KEY_PRESSED, [$this, 'keypressHandler']);
        Tui::$observer->off(Observer::MOUSE_LEFT_DOWN, [$this, 'mouseDownHandler']);
    }

    /**
     * Handles KeyPressEvents to turn them into clicks.  Adds a little animation
     * to give the user feedback
     * @param KeyPressEvent $event
     * @param KeyPressEvent $event The KeyPressEvent that triggered this method to be called
     */
    public function keypressHandler(KeyPressEvent $event) {
        if ($event->description === "{$this->keyModifier}{$this->shortcutKey}") {
            $this->owner->onMouseDown($event);
            time_nanosleep(0, 250000000);
            $this->owner->onMouseUp($event);
            $this->owner->trigger(self::CLICK_EVENT, new ControlEvent());
            $event->handled = true;
        }
    }

    /**
     * When the mouse goes down, we care if it's inside our rect.  So we start
     * listening for the mouse up to see if THAT's inside our rect.  If it is,
     * then it's a click.  I think this can be overridden.
     * @param MouseEvent $event The MouseEvent that triggered this method to be called
     */
    public function mouseDownHandler(MouseEvent $event) {
        /**
         * turn off any errant listeners in case the last mouse up happened
         * offscreen or something
         */
        #Debug::message(json_encode($this->owner));

        Tui::$observer->off(Observer::MOUSE_LEFT_UP, [$this, 'mouseUpHandler']);
        $rect = $this->owner->absoluteRectangle;
        Debug::message('event:' . json_encode($event));
        Debug::message('my rect:' . json_encode($rect));
        if ($rect->pointInMe($event->point)) {

            if (method_exists($this->owner, 'onMouseDown')) {
                $this->owner->onMouseDown($event);
            }
            /** we only care about mouse ups if we've already registered a mouse down */
            Tui::$observer->on(Observer::MOUSE_LEFT_UP, [$this, 'mouseUpHandler']);
            $event->handled = true;
        }
    }

    /**
     * Check if the mouse came inside our rectangle.  If it did, then it's a click.
     * I think this can be overridden.
     * @param MouseEvent $event The MouseEvent that triggered this method to be called
     */
    public function mouseUpHandler(MouseEvent $event) {
        $rect = $this->owner->absoluteRectangle;
        if ($rect->pointInMe($event->point)) { //$this->pMouseDown && Boxy::pointInRectangle($event->point, $rect
            if (method_exists($this->owner, 'onMouseUp')) {
                $this->owner->onMouseUp($event);
            }
            $this->owner->trigger(self::CLICK_EVENT, new ControlEvent());
            $event->handled = true;
        }
        // detach ourself
        Tui::$observer->off(Observer::MOUSE_LEFT_UP, [$this, 'mouseUpHandler']);
    }

}
