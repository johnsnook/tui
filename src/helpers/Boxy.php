<?php

/**
 * @author John Snook
 * @date May 13, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace tui\helpers;

use \tui\elements\Element;
use \tui\helpers\Point;
use \tui\helpers\Rectangle;
use \tui\components\Style;

/**
 * Helper class provide various rectangle functions
 */
abstract class Boxy {

    /**
     *
     * @param \\tui\helpers\Point $p
     * @param \\tui\helpers\Rectangle $r
     * @return boolean
     */
    public static function pointInRectangle(Point $p, Rectangle $r) {
        return ( $p->top >= $r->top && $p->top <= $r->top + $r->height - 1) &&
                ( $p->left >= $r->left && $p->left <= $r->left + $r->width - 1 );
    }

    /**
     * Modifies the Elements rectangle properties with adjusted properties.
     * Processed y down, so setting $position = Y | BOTTOM will process
     * BOTTOM last, overriding Y
     *
     * @param \\tui\elements\Element $subject The element whose
     * $rectangle attributes we're adjusting
     */
    public static function applyStyle(Element $subject) {
        $style = $subject->style;

        $container = $subject->owner;
        if (empty($subject->owner)) {
            $container = Screen::getScreenRect();
        }
        if ($subject instanceof \tui\elements\menu\MenuBar) {
//			Debug::log($subject, [
//				'$subject->width === Dimensions::NOT_SET' => $subject->width === Dimensions::NOT_SET,
//				'gettype($style->width) === \'integer\' && $subject->width === Dimensions::NOT_SET' => gettype($style->width) === 'integer' && $subject->width === Dimensions::NOT_SET,
//				'strpos($style->width, \'%\')!==false' => strpos($style->width, '%') !== false,
//			]);
        }
        if ($subject->width === Dimensions::NOT_SET) {
            if (gettype($style->width) === 'integer' && $subject->width === Dimensions::NOT_SET) {
                $subject->width = $style->width;
            } elseif (strpos($style->width, '%') !== false) {
//				if ($subject instanceof \\tui\elements\menu\MenuBar) {
//					Debug::log($subject, [
//						'$container->width' => $container->width,
//						'$style->width' => $style->width,
//						'$subject->rectangle' => $subject->rectangle
//					]);
//				}
                $subject->width = floor($container->width * ((int) $style->width / 100));
            }
        }
        if ($subject->height === Dimensions::NOT_SET) {
            if (gettype($style->height) === 'integer' && $subject->height === Dimensions::NOT_SET) {
                $subject->height = $style->height;
            } elseif (strpos($style->height, '%') !== false) {
                $subject->height = floor($container->height * ((int) $style->height / 100));
            }
        }

        /**
         * @todo finish folding in padding and margin shit
         */
        $addY = ($style->positioning !== Style::RELATIVE ? $container->top : 0);
        $addX = ($style->positioning !== Style::RELATIVE ? $container->left : 0);

        if ($subject->left === Point::NOT_SET) {
            if ($style->align & Style::LEFT) {
                $subject->left = $addX + $subject->style->marginLeft + $container->style->paddingLeft;
            } elseif ($style->align & Style::RIGHT) {
                $subject->left = $addX + $container->width - $subject->width - $container->style->paddingRight - $subject->style->marginRight;
            }
            if ($style->align & Style::HORIZONTAL) {
                $addX = ($style->positioning !== Style::RELATIVE ? $container->left : 0);
                $subject->left = $addX + round(($container->width / 2) - ($subject->width / 2));
            }
        }

        if ($subject->top === Point::NOT_SET) {
            if ($style->align & Style::TOP) {
                $subject->top = $addY + $subject->style->marginTop + $container->style->paddingTop;
            } elseif ($style->align & Style::BOTTOM) {
                $subject->top = $addY + $container->height - $subject->height - $container->style->paddingBottom - $subject->style->marginBottom;
            }
            if ($style->align & Style::VERTICAL) {
                $addY = ($style->positioning !== Style::RELATIVE ? $container->top : 0);
                $subject->top = $addY + round(($container->height / 2) - ($subject->height / 2));
            }
        }
    }

    /**
     * Checks if the first $rectangle contains the second.
     *
     * @param $rectA first $rectangle
     * @param $rectB second $rectangle
     * @return <code>true</code> if <code>$rectA</code> contains <code>$rectB</code>
     */
    public static final function contains(Rectangle $rectA, Rectangle $rectB) {
        return ($rectB->left >= $rectA->left) && ($rectB->top >= $rectA->top) &&
                ($rectB->left + $rectB->width <= $rectA->left + $rectA->width) && ($rectB->top + $rectB->height <= $rectA->top + $rectA->height);
    }

    /**
     * Checks if two $rectangles intersect
     *
     * @param $rectA first $rectangle
     * @param $rectB second $rectangle
     * @return <code>true</code> if <code>$rectA</code> and <code>$rectB</code> intersect
     */
    public static final function intersects(Rectangle $rectA, Rectangle $rectB) {
        return !(($rectB->left + $rectB->width <= $rectA->left) ||
                ($rectB->top + $rectB->height <= $rectA->top) ||
                ($rectB->left >= $rectA->left + $rectA->width) ||
                ($rectB->top >= $rectA->top + $rectA->height));
    }

    /**
     * Computes the difference of two $rectangles. Difference of two $rectangles
     * can produce a maximum of four $rectangles. If the two $rectangles do not intersect
     * a zero-length array is returned.
     *
     * @param $rectA first $rectangle
     * @param $rectB second $rectangle
     * @return non-null array of <code>Rectangle</code>s, with length zero to four
     */
    public static function difference(Rectangle $rectA, Rectangle $rectB) {
        if ($rectB == null || !intersects($rectA, $rectB) || contains($rectB, $rectA))
            return new Rectangle();

        #Rectangle
        $result = null;
        #Rectangle top = null, bottom = null, left = null, right = null;
        $rectCount = 0;

        //compute the top $rectangle
        $raHeight = $rectB->top - $rectA->top;
        if (raHeight > 0) {
            $top = new Rectangle($rectA->top, $rectA->left, $raHeight, $rectA->width);
            $rectCount++;
        }

        //compute the bottom $rectangle
        $rbY = $rectB->top + $rectB->height;
        $rbHeight = $rectA->height - ($rbY - $rectA->top);
        if ($rbHeight > 0 && $rbY < $rectA->top + $rectA->height) {
            $bottom = new Rectangle($rbY, $rectA->left, $rbHeight, $rectA->width);
            $rectCount++;
        }

        $rectAYH = $rectA->top + $rectA->height;
        $y1 = $rectB->top > $rectA->top ? $rectB->top : $rectA->top;
        $y2 = $rbY < $rectAYH ? $rbY : $rectAYH;
        $rcHeight = $y2 - $y1;

        //compute the left $rectangle
        $rcWidth = $rectB->left - $rectA->left;
        if ($rcWidth > 0 && $rcHeight > 0) {
            $y = new Rectangle($y1, $rectA->left, $rcHeight, $rcWidth);
            $rectCount++;
        }

        //compute the right $rectangle
        $rbX = $rectB->left + $rectB->width;
        $rdWidth = $rectA->width - ($rbX - $rectA->left);
        if ($rdWidth > 0) {
            $right = new Rectangle($y1, $rbX, $rcHeight, $rdWidth);
            $rectCount++;
        }

        $result = [];
        $rectCount = 0;
        if ($top != null)
            $result[$rectCount++] = $top;
        if ($bottom != null)
            $result[$rectCount++] = $bottom;
        if ($y != null)
            $result[$rectCount++] = $y;
        if ($right != null)
            $result[$rectCount++] = $right;
        return result;
    }

    /**
     *
     * // Two $rectangles, assume the class name is `Rect`
     * Rect r1 = new Rect(x1, y2, w1, h1);
     * Rect r2 = new Rect(x3, y4, w2, h2);
     *
     * // get the coordinates of other points needed later:
     * int x2 = x1 + w1;
     * int x4 = x3 + w2;
     * int y1 = y2 - h1;
     * int y3 = y4 - h2;
     *
     * // find intersection:
     * int xL = Math.max(x1, x3);
     * int xR = Math.min(x2, x4);
     * if (xR <= xL)
     *     return null;
     * else {
     *     int yT = Math.max(y1, y3);
     *     int yB = Math.min(y2, y4);
     *     if (yB <= yT)
     *         return null;
     *     else
     *         return new Rect(xL, yB, xR-xL, yB-yT);
     * }
     *
     * @param \\tui\helpers\Rectangle $r1
     * @param \\tui\helpers\Rectangle $r2
     */
    public static function intersection(Rectangle $r1, Rectangle $r2) {
        /*
         * // get the coordinates of other points needed later:
         * int x2 = x1 + w1;
         * int x4 = x3 + w2;
         * int y1 = y2 - h1;
         * int y3 = y4 - h2;
         */
        $x2 = $r1->left + $r1->width;
        $x4 = $r2->left + $r2->width;
        $y1 = $r1->top - $r1->height;
        $y3 = $r2->top - $r2->height;

        /*
         * int xL = Math.max(x1, x3);
         * int xR = Math.min(x2, x4);
         */
        $xL = max([$r1->left, $r2->left]);
        $xR = min([$x2, $x4]);
        /**
         * Rect r1 = new Rect(x1, y2, w1, h1);
         * Rect r2 = new Rect(x3, y4, w2, h2);
         */
        if ($xR <= $xL) {
            return null;
        } else {
            $yT = max([$y1, $y3]);
            $yB = min([$r1->top, $r2->top]);
            if ($yB <= $yT) {
                return null;
            } else {
                return new Rectangle($xL, $yB, $xR - $xL, $yB - $yT);
            }
        }

        /*
         *
         *
         * if (xR <= xL)
         *     return null;
         * else {
         *     int yT = Math.max(y1, y3);
         *     int yB = Math.min(y2, y4);
         *     if (yB <= yT)
         *         return null;
         *     else
         *         return new Rect(xL, yB, xR-xL, yB-yT);
         * }
         */
    }

}
