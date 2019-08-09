<?php

/**
 * @author John Snook
 * @date Apr 27, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 * Description of MouseEvent
 */

namespace tui\events;

use \tui\helpers\Point;

/**
 * The user has click on something and dragged it
 * @property string $eventName
 * @property Point $startPoint The x and y of the event
 * @property Point $endPoint The x and y of the event
 */
class DragEvent extends \tui\base\Event {
    /** Events */
//    const DRAG_BEGIN = 'BeginDrag';
//    const DRAG_END = 'EndDrag';

    /**
     * @var Point The x and y of the event
     */
    public $startPoint;

    /**
     * @var Point The x and y of the event
     */
    public $endPoint;

    /**
     * @usage $this->move($this->top + $event->difference->top, $this->left + $event->difference->left);
     * @return Point The difference between the start and end points.
     */
    public function getDifference() {
        return new Point($this->endPoint->left - $this->startPoint->left, $this->endPoint->top - $this->startPoint->top);
    }

}
