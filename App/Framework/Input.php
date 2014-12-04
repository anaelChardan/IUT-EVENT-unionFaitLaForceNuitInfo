<?php

namespace App\Framework;

class Input {

	private static $stored = [];

	public static function has($name) {
		return array_key_exists($name, $_REQUEST) || array_key_exists($name, static::$stored);
	}

	public static function get($name, $fallback = '') {
		if (array_key_exists($name, $_REQUEST))
			return $_REQUEST[$name];
		elseif (array_key_exists($name, static::$stored))
			return static::$stored[$name];
		else
			return $fallback;

	}

	public static function push($name, $value) {
		static::$stored[$name] = $value;
	}
}