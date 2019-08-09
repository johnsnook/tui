<?php

/**
 * @author John Snook
 * @date Apr 28, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace tui\elements\menu;

use \tui\elements\Button;
use \tui\elements\Container;
use \tui\elements\Element;
use \tui\elements\menu\Separator;
use \tui\components\Observer;
use \tui\components\Style;
use \tui\helpers\Format;
use \tui\behaviors\ClickableBehavior;
use \tui\events\MouseEvent;
use Tui;

/**
 * A vertical menu, used primarily as a drop down, but can be hosted by other
 * containers
 */
class Menu extends Container { //implements ClickableInterface
    //use ClickableContainerTrait;

    private $maxLabelWidth = 0;

    /**
     * {@inheritDoc}
     * Set automatic visibility to false
     */
    public function init() {
        parent::init();
        $this->visible = false;
    }

    /**
     * {@inheritDoc}
     * Go through our elements and set the heights to 1 and turn off their
     * borders.  Also figure out the maximum width of the buttons' labels to
     * set our width
     */
    public function initializeElements() {
        parent::initializeElements();
        foreach ($this->elements as $element) {
            if ($element instanceof Button) {
                if ($element->labelLength > $this->maxLabelWidth) {
                    $this->maxLabelWidth = $element->labelLength;
                }
                $element->on(MouseEvent::CLICK, [$this, 'hideMenu']);
            }
        }
    }

    /**
     * {@inheritDoc}
     * Builds a menu, using a mix of buttons & separators and sets it's position
     * under it's owner, IF it's a MenuBarItem.  Can also be instanced as being
     * owned by a Window, but you must set the menu position style to relative
     *
     * @return boolean Should we be show?
     */
    public function beforeShow() {
        /**
         * Instead of calling parent::beforeShow(), which is \tui\elements\Container,
         * we'll call our grandparent, and call onReady for each of our elements
         *
         */
        if (!Element::beforeShow()) {
            return false;
        }

        /** if we're owned by a MenuBarItem, position ourself accordingly. */
        if ($this->owner instanceof MenuBarItem) {
            $this->owner->on(Element::MOVE_EVENT, [$this, 'onOwnerMove']);
            $rect = $this->owner->absolutePosition;
            $this->move($rect->top + 1, $rect->left);
        }

        $this->style->bgColor = $this->owner->style->bgColor;
        $this->resize(count($this->elements) + 2, $this->maxLabelWidth + 4);
        #$i = $this->top + 1;
        $i = 2;
        foreach ($this->elements as $element) {
            $element->style->bgColor = $this->style->bgColor;
            if ($element instanceof Separator) {
                $element->resize(1, $this->width);
                $element->move($i++, 0);
            } elseif ($element instanceof Button) {
                $element->style->borderWidth = Style::NONE;
                $element->keyModifier = '';
                $element->shortcutKeyDecorator = $this->style->getPen(Format::xtermFgColor(255), $this->style->bgColor);
                $element->style->paddingLeft = 1;
                $element->style->textAlign = Style::NONE;
                $element->resize(1, $this->width - 2);
                $element->move($i++, 2);
                $element->on(ClickableBehavior::CLICK_EVENT, [$this, 'hideMenu']);
                #$element->bufferLabel();
            }
        }
        return true;
    }

    public function onOwnerMove($event) {
        $rect = $this->owner->absolutePosition;
        $this->move($rect->top + 1, $rect->left);
    }

    /**
     * {@inheritDoc}
     */
    public function afterShow() {
        parent::afterShow();
        Tui::$observer->on(Observer::MOUSE_LEFT_UP, [$this, 'hideMenu'], false);
    }

    /**
     * Hides the menu
     */
    public function hideMenu($event) {
        $this->hide();
    }

    /**
     * {@inheritDoc}
     */
    public function afterHide() {
        parent::afterHide();
        Tui::$observer->off(Observer::MOUSE_LEFT_UP, [$this, 'hideMenu']);
        foreach ($this->elements as $element) {
            $element->off(ClickableBehavior::CLICK_EVENT, [$this, 'hideMenu']);
        }
    }

}
