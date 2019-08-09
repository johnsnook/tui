<?php

/**
 * @author John Snook
 * @date May 5, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace tui\elements\window;

use \tui\elements\Container;
use \tui\helpers\Point;
use \tui\elements\Button;
#use \tui\behaviors\DraggableBehavior;
use \tui\helpers\Rectangle;
use \tui\components\Style;
use \tui\helpers\Unicodes;

/**
 * {@inheritDoc}
 * An window object that can contain form controls, be resized, minimized,
 * maximized and moved.
 * @todo add shadow
 */
class Window extends Container {

    //use \\tui\traits\DraggableTrait;

    public $title = 'No Title Set';
    private $titleBar;
    private $isClosed = true;
    public $isResizable = true;
    public $hasControlBox = true;
    private $controlBox = null;
    public $hasMaxButton = true;
    private $maxButton = null;
    public $hasMinButton = true;
    private $minButton = null;

    /**
     * {@inheritDoc}
     */
    public function init() {
        parent::init();
        $this->buildWindow();
    }

    /**
     * Add all the window controls
     */
    public function buildWindow() {
        $css = [
            'borderWidth' => Style::NONE,
            'borderStyle' => Style::NONE,
            'bgColor' => $this->style->bgColor,
            'fgColor' => $this->style->fgColor,
            'position' => Style::RELATIVE,
            'pull' => Style::TOP,
            'width' => 4, 'height' => 1,
            'textAlign' => Style::NONE,
        ];
        $titleWidth = $this->width;
        if ($this->hasControlBox) {
            $this->controlBox = new Button([
                'id' => 'controlBox', 'owner' => $this,
                'css' => array_merge($css, ['width' => 3, 'height' => 1]),
                'top' => 1, 'left' => 2, 'height' => 1, 'width' => 3,
                'label' => Unicodes::SINGLE_RIGHT_MID . Unicodes::BLACK_SQUARE . Unicodes::SINGLE_LEFT_MID
            ]);
            $titleWidth -= 4;
            #$this->controlBox->onReady();
        }

        if ($this->isResizable) {
            if ($this->hasMinButton) {
                $this->minButton = new Button([
                    'id' => 'minButton', 'owner' => $this,
                    'css' => array_merge($css, ['pull' => Style::RIGHT + Style::TOP]),
                    'height' => 1, 'width' => 3,
                    'label' => Unicodes::SINGLE_VERTICAL . Unicodes::TRIANGLE_DOWN . Unicodes::SINGLE_VERTICAL
                ]);
                $titleWidth -= 3;
            }
            if ($this->hasMaxButton) {
                $this->maxButton = new Button([
                    'id' => 'maxButton', 'owner' => $this,
                    'css' => array_merge($css, ['pull' => Style::RIGHT + Style::TOP]),
                    'height' => 1, 'width' => 3,
                    'label' => Unicodes::SINGLE_VERTICAL . Unicodes::TRIANGLE_UP . Unicodes::SINGLE_VERTICAL
                ]);
                $titleWidth -= 3;
            }
        }

        if (!empty($this->title)) {
            $this->titleBar = new TitleBar([
                'owner' => $this,
                'label' => $this->title,
                'left' => ($this->hasControlBox ? 5 : 1),
                'width' => $titleWidth
            ]);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function beforeShow() {
        if (parent::beforeShow()) {
//            $title = Unicodes::mbStringPad($this->title, $this->width, Unicodes::THREE_LINES, STR_PAD_BOTH);
//            $pen = $this->style->getPen(Format::FG_GREY, Format::xtermBgColor(93), Format::BOLD);
            #$this->buffer->writeToRow($title, 0, 0, $pen);
            $this->buffer->writeToColumn('12345678901234567890', 1, 1);
            $this->buffer->writeToRow('12345678901234567890', 1, 1);
            return true;
        }
        return false;
    }

    /**
     * Windows aren't just shown, they're opened.
     */
    public function open(Point $point = null) {
        $this->isClosed = false;
        if (!is_null($point)) {
            $this->move($point->top, $point->left);
        }
        $this->show(true);
        if ($this->hasControlBox) {
            $this->controlBox->show();
        }
        if (!empty($this->title)) {
            $this->titleBar->dragRectangle = new Rectangle($this->top, $this->left, 1, $this->width);
            $this->titleBar->show();
        }
    }

    /**
     * {@inheritDoc}
     * Using $isClosed prevents us from being shown automatically
     */
    public function show($forceVisible = false) {
        if ($this->isClosed) {
            $this->isClosed = false;
            parent::show();
        }
    }

    /**
     * {@inheritDoc}
     * Using $isClosed prevents us from being drawn automatically
     */
    public function draw() {
        if (!$this->isClosed) {
            parent::draw();
        }
    }

    public function move($y, $x) {
        if ($this->visible) {
            $this->hide();
            parent::move($y, $x);
            $this->show(true);
        }
    }

    /**
     * {@inheritDoc}
     * Set $isClosed prevents us from being shown automatically
     */
    public function close() {
        $this->isClosed = true;
        $this->hide();
    }

    public function afterShow() {
        parent::afterShow();
    }

    public function afterHide() {
        parent::afterHide();
    }

}
