<?php

namespace App\Framework;

class Module {

	protected static $app;

	public function __construct($app) {
		static::$app = $app;
	}
}