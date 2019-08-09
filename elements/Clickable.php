<?php

/**
 * @author John Snook
 * @date Apr 28, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace tui\elements;

use \tui\components\Style;
use \tui\elements\Control;
use \tui\events\KeyPressEvent;
use \tui\events\MouseEvent;
use Tui;

/**
 * Signals interest in and provides method for ClickEvents
 */
class Clickable extends Control {

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

    /**
     * @Description Event handler for click event.  Signature function($event){}
     * @var callable
     */
    public $click;

    /**
     * Calls the user function if there is one
     * @param KeyPressEvent | MouseEvent $event
     */
    public function onClick($event = null) {
        if (isset($this->click)) {
            call_user_func($this->click, $event);
        }
        $this->trigger($event::CLICK, $event);
    }

    /**
     * {@inheritDoc}
     */
    public function onReady() {
        parent::onReady();
        $this->bufferLabel();
    }

    /**
     * This class has the ability to use a shortcut key.  If a label has an
     * underscore before a letter, then that letter becomes the shortcut keys letter.
     * So we need find the position of the underscore, remove it, and highlight
     * the character by adding an underline
     *
     * Welcome the 3rd edition of "prepareLabel".  Takes a string with or without
     * an underscore and writes it to the center of the buffer.  At some point
     * I should add text justification to the Style.  Maybe a $labelRect?
     */
    protected function bufferLabel() {

        if ($this->style->textAlign === Style::CENTER) {
            $y = round(($this->height > 2) ? ($this->height / 2) : 1);
            $x = round(($this->width / 2) - ($this->labelLength / 2));
        } else {
            $y = 1 + $this->style->paddingTop;
            $x = 1 + $this->style->paddingLeft;
        }

        $label = str_replace('_', '', $this->pLabel);
        $writ = $this->buffer->writeToRow($label, $y - 1, $x - 1);

        if ($this->id === 'fileMenuItem') {
            Debug::log($this,[
                '$x' => $x,
                '$y' => $y,
                '$writ' => $writ,
                '$this->style->textAlign' => $this->style->textAlign
            ]);
        }

        if (($shortcutPos = strpos($this->pLabel, '_')) !== false) {
            $letter = substr($label, $shortcutPos, 1);
            $this->shortcutKey = strtolower($letter);
            $this->buffer->code($y - 1, $x + $shortcutPos - 1, $this->shortcutKeyDecorator);
            #Debug::log($this,[$this->id => $this->shortcutKeyDecorator]);
        } else {
            $this->shortcutKey = null;
        }
    }

    /**
     * {@inheritDoc}
     * We care about 3 kinds of events: key press, mouse down and mouse up.  It's
     * not a proper click unless the mouse down and mouse up occur within our rectangle.
     *
     * We really only care about mouse up events after a mouse down happens in our
     * rectangle, so we reserve attaching a listener for mouse up until after the
     * mouse down event.
     */
    public function afterShow() {
        parent::afterShow();
        Tui::$observer->on(KeyPressEvent::EVENT_KEY_PRESSED, [$this, 'keypressHandler']);
        Tui::$observer->on(MouseEvent::EVENT_MOUSE_LEFT_DOWN, [$this, 'mouseDownHandler']);
    }

    /**
     * {@inheritDoc}
     */
    public function afterHide() {
        parent::afterHide();
        Tui::$observer->off(KeyPressEvent::EVENT_KEY_PRESSED, [$this, 'keypressHandler']);
        Tui::$observer->off(MouseEvent::EVENT_MOUSE_LEFT_DOWN, [$this, 'mouseDownHandler']);
    }

    /**
     * Handles KeyPressEvents to turn them into clicks.  Adds a little animation
     * to give the user feedback
     * @param KeyPressEvent $event
     */
    public function keypressHandler(KeyPressEvent $event) {
        if ($event->description === "{$this->keyModifier}{$this->shortcutKey}") {
            $this->onMouseDown(null);
            time_nanosleep(0, 330000000);
            $this->onMouseUp(null);

            $event->sender = $this;
            $this->onClick($event);
            $event->handled = true;
        }
    }

    /**
     * When the mouse goes down, we care if it's inside our rect.  So we start
     * listening for the mouse up to see if THAT's inside our rect.  If it is,
     * then it's a click.  I think this can be overridden.
     * @param MouseEvent $event
     */
    public function mouseDownHandler(MouseEvent $event) {
        /**
         * turn off any errant listeners incase the last mouse up happened
         * offscreen or soemthing
         */
        Tui::$observer->off(MouseEvent::EVENT_MOUSE_LEFT_UP, [$this, 'mouseUpHandler']);
        $rect = $this->absoluteRectangle;
        if ($rect->pointInMe($event->point)) {
            $this->onMouseDown($event);
            //$event->handled = true;

            /**
             * we only care about mouse ups if we've already registered a mouse down
             */
            Tui::$observer->on(MouseEvent::EVENT_MOUSE_LEFT_UP, [$this, 'mouseUpHandler']);
        }
    }

    /**
     * Check if the mouse came inside our rect.  If it did, then it's a click.
     * I think this can be overridden.
     * @param MouseEvent $event
     */
    public function mouseUpHandler(MouseEvent $event) {
        $rect = $this->absoluteRectangle;
        $this->onMouseUp($event);
        if ($rect->pointInMe($event->point)) { //$this->pMouseDown && Boxy::pointInRectangle($event->point, $rect
            $event->sender = $this;
            $this->onClick($event);
            $event->handled = true;
        }
        // detach ourself
        Tui::$observer->off(MouseEvent::EVENT_MOUSE_LEFT_UP, [$this, 'mouseUpHandler']);
    }

}
