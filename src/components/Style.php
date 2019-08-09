<?php

/**
 * @author John Snook
 * @date May 10, 2018
 * @license https://snooky.biz/site/license
 * @copyright 2018 John Snook Consulting
 */

namespace tui\components;

use \tui\helpers\Format;

/**
 * The idea here is to provide faux css type functionality where some common
 * attributes concerning formtting outpout can be set by default with easy
 * customization
 * @property string $bgPattern The character used for blank dimensionss, defaults to SPACE
 * @property string $bgColor;
 * @property string $fgColor ;
 * @property string $decoration = Format::NORMAL;
 * @property integer $paddingTop = 0;
 * @property integer $paddingRight = 0;
 * @property integer $paddingBottom = 0;
 * @property integer $paddingLeft = 0;
 * @property integer $marginTop = 0;
 * @property integer $marginRight = 0;
 * @property integer $marginBottom = 0;
 * @property integer $marginLeft = 0;
 * @property string $positioning = self::ABSOLUTE;
 * @property string $pull = self::NONE;
 * @property string $borderWidth = self::SINGLE;
 * @property string $borderStyle = self::OUTSET;
 * @property string $borderLitColor = self::NONE;
 * @property string $borderShadedColor = self::NONE;
 * @property string|integer $width = self::NONE;
 * @property string|integer $height = self::NONE;
 */
class Style {

	/** bitmask group */
	const NONE = 'none';
	const TOP = 1; //'top';
	const BOTTOM = 2; //'bottom';
	const LEFT = 4; //'left';
	const RIGHT = 8; //'right';
	const VERTICAL = 16;
	const HORIZONTAL = 32;
	const SINGLE = 'single';
	const DOUBLE = 'double';
	const INSET = 'inset';
	const OUTSET = 'outset';
	const AUTO = 'auto';
	const RELATIVE = 'relative';
	const ABSOLUTE = 'absolute';
	const INLINE = 'inline';
	const CENTER = 'center';

	/**
	 *
	 * @var array The style array
	 */
	private $css;

	/**
	 * Pass the array
	 * @param array $css "css" lol
	 */
	public function __construct($css = []) {
		$this->css = $css;
	}

	/**
	 * Returns the style stetting if it exists, false if not
	 * @param string $name The name of the style attribute
	 * @return mixed string | boolean
	 */
	public function __get($name) {
		if (array_key_exists($name, $this->css)) {
			return $this->css[$name];
		} elseif ($name === 'pen') {
			/** make it easy to get the pen! */
			return $this->getPen();
		} elseif ($name === 'css') {
			/** make it easy to get the pen! */
			return $this->css;
		}
		return FALSE;
	}

	public function __set($name, $value) {
		$this->css[$name] = $value;
	}

	/**
	 * Allow user to merge in faux css, overwriting default values
	 * @param array $css
	 * @throws \UnexpectedValueException
	 */
	public function addCss($css) {
		if (!is_array($css)) {
			throw new \UnexpectedValueException('Style::addCss expects an array, ' . gettype($css) . ' given.');
		} elseif (!empty($css)) {
			$this->css = array_merge($this->css, $css);
		}
	}

	/**
	 * Will return a string formatted with the given ANSI style.
	 *
	 * @param string $string the string to be formatted
	 * @param array $format An array containing formatting values.
	 * You can pass any of the `FG_*`, `BG_*` and `TEXT_*` constants
	 * and also [[xtermFgColor]] and [[xtermBgColor]] to specify a format.
	 * @return string
	 */
	public function formattedString($string, $pen = null) {
		if (is_null($pen)) {
			$pen = $this->getPen();
		}
		return $pen . $string . Format::ESC . "0m";
	}

	/**
	 * Merges foreground, background and text decoration into an ansi escape code
	 * The idea is to allow an object to have it's style defined pen, or modify
	 * it easily/temporarily if needed
	 *
	 * @param intger $fgColor ANSI code (@see Format::FG_*)
	 * @param intger $bgColor ANSI code (@see Format::BG_*)
	 * @param intger $decoration Ansi code (@see Format::BOLD, etc)
	 * @return string ANSI escape code combining the relevant options
	 */
	public function getPen($fgColor = null, $bgColor = null, $decoration = null) {
		$return = [];

		if ($fgColor) {
			$return[] = $fgColor;
		} elseif ($this->fgColor) {
			$return[] = $this->fgColor;
		}

		if ($bgColor) {
			$return[] = $bgColor;
		} elseif ($this->bgColor) {
			$return[] = $this->bgColor;
		}

		if ($decoration) {
			$return[] = $decoration;
		} elseif ($this->decoration) {
			$return[] = $this->decoration;
		}

		return Format::ansiCode($return);
	}

	/**
	 * Convert to string
	 * @return string
	 */
	public function __toString() {
		return json_encode($this->css, 224);
	}

}
