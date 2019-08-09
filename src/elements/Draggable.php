<?php

/**
 * @author John Snook
 * @date May 20, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace tui\elements;

use \tui\elements\Control;
use \tui\events\KeyPressEvent;
use \tui\events\MouseEvent;
use \tui\events\DragEvent;
use \tui\helpers\Rectangle;
use \tui\helpers\Keys;

class Draggable extends Control {

    /**
     * @event Event an event raised when the user presses the mouse button.
     */
    const DRAG_BEGIN = 'BeginDrag';

    /**
     * @event Event an event raised when the user releases the mouse button.
     */
    const DRAG_END = 'EndDrag';

    /**
     * @Description Event handler for user event.  Signature function(Draggable $event){}
     *
     * @var callable Allows user to define an ad hoc function in the configuration
     * that will be called when the drag event begins
     */
    public $dragStart;

    /**
     * @Description Event handler for user event.  Signature function(Draggable $event){}
     * @var callable Allows user to define an ad hoc function in the configuration
     * that will be called when the drag event ends
     */
    public $dragEnd;

    /**
     * @var Rectangle The rectangle that you drag this object by
     */
    protected $dragRect;

    /**
     * @var DragEvent Holds the start and end points
     */
    private $dragEvent;

    /**
     * Calls the user function if there is one and can be overridden by child
     * classes
     * @param DragEvent $event
     */
    public function onStartDrag(DragEvent $event) {
        if (isset($this->dragStart)) {
            call_user_func($this->dragStart, $event);
        }
    }

    /**
     * Calls the user function if there is one and can be overridden by child
     * classes
     * @param DragEvent $event
     */
    public function onEndDrag(DragEvent $event) {
        if (isset($this->dragEnd)) {
            call_user_func($this->dragEnd, $event);
        }
    }

    /**
     * We really only care about mouse up events after a mouse down happens in our
     * rectangle, so we reserve attaching a listener for mouse up until after the
     * mouse down event.
     */
    public function attachClickEvents() {
        Tui::$observer->on(MouseEvent::EVENT_MOUSE_LEFT_DOWN, [$this, 'mouseDownHandler']);
    }

    /**
     * @param MouseEvent $event Contains the x and y of the mouse down
     */
    public function mouseDownHandler(MouseEvent $event) {
        /**
         * turn off any errant listeners incase the last mouse up happened
         * offscreen or something
         */
        Tui::$observer->off(MouseEvent::EVENT_MOUSE_LEFT_UP, [$this, 'mouseUpHandler']);
        if ($this->dragRect->pointInMe($event->point)) {
            $this->dragEvent = new DragEvent([
                'startPoint' => $event->point
            ]);
            $this->trigger(self::DRAG_BEGIN, $this->dragEvent);
            /** listen for the mouse up */
            Tui::$observer->on(MouseEvent::EVENT_MOUSE_LEFT_UP, [$this, 'mouseUpHandler']);
            $event->handled = true;
        }
    }

    public function mouseUpHandler(MouseEvent $event) {
        // detach ourself
        Tui::$observer->off(MouseEvent::EVENT_MOUSE_LEFT_UP, [$this, 'mouseUpHandler']);
        $this->dragEvent->endPoint = $event->point;
        $this->trigger(self::DRAG_END, $this->dragEvent);
        $event->handled = true;
    }

    public function afterHide() {
        parent::afterHide();
        Tui::$observer->off(MouseEvent::EVENT_MOUSE_LEFT_DOWN, [$this, 'mouseDownHandler']);
    }

    public function keypressHandler(KeyPressEvent $event) {
        switch ($event->rawData) {
            case Keys::ARROW_UP:
                $this->move($this->left, $this->top + 1);
                break;
            case Keys::CTRL_ARROW_UP:
                $this->move($this->left, $this->top - 10);
                break;
            case Keys::ARROW_RIGHT:
                $this->move($this->left + 1, $this->top);
                break;
            case Keys::CTRL_ARROW_RIGHT:
                $this->move($this->left + 10, $this->top);
                break;
            case Keys::ARROW_DOWN:
                $this->move($this->left, $this->top + 1);
                break;
            case Keys::CTRL_ARROW_DOWN:
                $this->move($this->left, $this->top + 10);
                break;
            case Keys::ARROW_LEFT:
                $this->move($this->left - 1, $this->top);
                break;
            case Keys::CTRL_ARROW_LEFT:
                $this->move($this->left - 10, $this->top);
                break;
        }
    }

}
