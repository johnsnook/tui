<?php

namespace tui\helpers;

use \tui\components\Buffer;
use \tui\components\Style;
use \tui\Tui;

/**
 * @author John Snook
 * @date Apr 26, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 *
 * @property integer $pStyle
 * Loads the special characters from json files and shades them according to
 * pStyle.  We draw empty borders for consistency
 */
class Border {

	const UPPER_LEFT = '┌──';
	const LOWER_RIGHT = '──┘';

	private static $borderLitColor = '38;5;253';
	private static $borderShadedColor = '38;5;241';

	public static function apply(Buffer &$buffer) {
		$style = clone $buffer->style;
		$style->addCss(Tui::getStyle('Border'));

		$chars = static::getChars($style->borderWidth);

		$horz = str_split(str_repeat($chars->horizontal, $buffer->width - 2), 3);
		$vert = str_split(str_repeat($chars->vertical, $buffer->height - 2), 3);

		/** bottom left */
		$buffer->writeToRow([$chars->bottomLeft], $buffer->height - 1, 0, static::getPen(static::UPPER_LEFT, $style));

		/** left */
		$buffer->writeToColumn($vert, 1, 0, static::getPen(static::UPPER_LEFT, $style));

		/** top left */
		$buffer->writeToRow([$chars->topLeft], 0, 0, static::getPen(static::UPPER_LEFT, $style));

		/** top */
		$buffer->writeToRow($horz, 0, 1, static::getPen(static::UPPER_LEFT, $style));

		/** top right */
		$buffer->writeToRow([$chars->topRight], 0, $buffer->width - 1, static::getPen(static::LOWER_RIGHT, $style));

		/** right */
		$buffer->writeToColumn($vert, 1, $buffer->width - 1, static::getPen(static::LOWER_RIGHT, $style));

		/** bottom right */
		$buffer->writeToRow([$chars->bottomRight], $buffer->height - 1, $buffer->width - 1, static::getPen(static::LOWER_RIGHT, $style));

		/** bottom */
		$buffer->writeToRow($horz, $buffer->height - 1, 1, static::getPen(static::LOWER_RIGHT, $style));
	}

	/**
	 * Let's wrap Style::getPen() to get the right kind of formatting for our border
	 * @param string $corner UPPER_LEFT or LOWER_RIGHT
	 * @return string The ansi code
	 */
	private static function getPen($corner, $style) {
		$fgColor = $style->fgColor;
		$borderLitColor = ($style->borderLitColor ? $style->borderLitColor : static::$borderLitColor);
		$borderShadedColor = ($style->borderShadedColor ? $style->borderShadedColor : static::$borderShadedColor);
		if ($style->borderStyle === Style::INSET) {
			$fgColor = ($corner === static::UPPER_LEFT ? $borderShadedColor : $borderLitColor);
		} elseif ($style->borderStyle === Style::OUTSET) {
			$fgColor = ($corner === static::UPPER_LEFT ? $borderLitColor : $borderShadedColor);
		}
		return $style->getPen($fgColor);
	}

	public static function bufferSeparator($style, &$buffer, $row = 0) {
		$chars = static::getChars($style->borderWidth);

		$horz = str_split(str_repeat($chars->horizontal, $buffer->width - 2), 3);

		/** left */
		$buffer->writeToRow([$chars->leftMid], $row, 0, static::getPen(static::UPPER_LEFT, $style));

		/** middle */
		$buffer->writeToRow($horz, 0, 1, static::getPen(static::UPPER_LEFT, $style));

		/** right */
		$buffer->writeToRow([$chars->rightMid], 0, $buffer->width - 1, static::getPen(static::LOWER_RIGHT, $style));
	}

	private static function getChars($borderWidth) {
		if ($borderWidth === Style::SINGLE) {
			return (object) [
						"horizontal" => "─",
						"vertical" => "│",
						"topLeft" => "┌",
						"topMid" => "┬",
						"topRight" => "┐",
						"rightMid" => "┤",
						"bottomRight" => "┘",
						"bottomMid" => "┴",
						"bottomLeft" => "└",
						"leftMid" => "├",
						"cross" => "┼"
			];
		}
		if ($borderWidth === Style::DOUBLE) {
			return (object) [
						"horizontal" => "═",
						"vertical" => "║",
						"topLeft" => "╔",
						"topMid" => "╦",
						"topRight" => "╗",
						"rightMid" => "╣",
						"bottomRight" => "╝",
						"bottomMid" => "╩",
						"bottomLeft" => "╚",
						"leftMid" => "╠",
						"cross" => "╬"
			];
		}
	}

}
