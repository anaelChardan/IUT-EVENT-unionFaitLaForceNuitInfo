<?php

namespace Modules\Vertex\Auth;

use App\Framework\Module;

class Auth extends Module {

	protected $loginField = "username";
	protected $passwordField = "password";
	protected $tokenField = "token";

	public function __construct($app) {
		parent::__construct($app);

		$this->loginField = static::getConfig('loginField', 'username');
		$this->passwordField = static::getConfig('passwordField', 'password');
		$this->tokenField = static::getConfig('tokenField', 'token');
	}

	public function getModel() {
		return $this->getConfig('model');
	}

	private function getConfig($name, $fallback) {

		if (static::$app->hasConfig('auth', $name))
			return static::$app->getConfig('auth', $name);
		else
			return $fallback;
	}

	private function isRemembered() {
		return isset($_COOKIE['auth_remember']) ? $_COOKIE['auth_remember'] : false;
	}

	private function hasToken() {
		return $this->isRemember() ? isset($_SESSION['auth_token']) : isset($_COOKIE['auth_token']);
	}

	private function getToken() {
		return $this->isRemember() ? $_SESSION['auth_token'] : $_COOKIE['auth_token'];
	}

	public function isLogged() {
		if (!$this->hasToken())
			return false;

	}

	public function isGuest() {
		return !$this->isLogged();
	}

	public function attempt($username, $password) {
		
	}



}