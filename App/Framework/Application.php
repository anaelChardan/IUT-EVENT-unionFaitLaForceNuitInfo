<?php 

namespace App\Framework;

class Application {

	private $config = [];
	private $envs = [];
	private $aliases = [];
	private $modules = [];
	private $loadedModules = [];
	public $db;

	public function __construct() {
		$this->loadConfig();
		$this->forceRequestParameters();
		$this->loadDatabase();
		$this->loadModules();
	}

	public function loadConfig() {
		$this->config = require APP_ROOT."/config/config.php";
		$this->envs = require APP_ROOT."/config/envs.php";

		if (file_exists(APP_ROOT."/config/".$this->currentEnvironment().".php")) {
			$envConfig = require APP_ROOT."/config/".$this->currentEnvironment().".php";
			$this->config = array_merge_recursive($this->config, $envConfig);
		}
	}

	public function forceRequestParameters() {
		if (!array_key_exists(CONTROLLER_ACCESSOR, $_GET)) {
			header('Location: ?'.CONTROLLER_ACCESSOR.'='.$this->getConfig('default_controller'));
		}
		if (!array_key_exists(ACTION_ACCESSOR, $_GET)) {
			header('Location: ?'.CONTROLLER_ACCESSOR.'='.$this->getControllerName().'&'.ACTION_ACCESSOR.'='.$this->getConfig('default_action'));
		}
	}

	public function loadDatabase() {
		if ($this->hasConfig('database')) {
			$this->db = new Database($this);
		} else {
			$this->db = null;
		}
	}

	public function loadModules() {
		$modules = require APP_ROOT."/config/modules.php";

		foreach ($modules as $module => $class) {
			$this->modules[$module] = $class;
		}
	}

	public function __get($attr) {
		foreach ($this->modules as $name => $class) {
			if ($name == $attr) {
				if (!array_key_exists($attr, $this->loadedModules))
					$this->loadedModules[$attr] = new $class($this);
				return $this->loadedModules[$attr];
			}
		}
	}

	public function hasConfig($name, $sub = '') {
		if ($sub == '')
			return array_key_exists($name, $this->config);
		else
			return array_key_exists($name, $this->config) && array_key_exists($sub, $this->config[$name]);
	}

	public function getConfig($name, $sub = '') {
		if ($sub == '')
			return $this->config[$name];
		else
			return $this->config[$name][$sub];
	}

	public function getControllerName() {
		return (array_key_exists(CONTROLLER_ACCESSOR, $_GET)) ? $_GET[CONTROLLER_ACCESSOR] : $this->getConfig('default_controller');
	}

	public function getActionName() {
		return strtolower($_SERVER['REQUEST_METHOD']).ucwords((array_key_exists(ACTION_ACCESSOR, $_GET)) ? $_GET[ACTION_ACCESSOR] : $this->getConfig('default_action'));
	}

	public function getRawActionName() {
		return strtolower((array_key_exists(ACTION_ACCESSOR, $_GET)) ? $_GET[ACTION_ACCESSOR] : $this->getConfig('default_action'));
	}

	public function generateRequest() {
		$req = new Request($this);
		return $req;
	}

	public function render() {
		echo $this->generateRequest()->getResponse();
		$this->close();
	}

	public function currentEnvironment() {
		$res = "prod";
		foreach ($this->envs as $env => $hosts) {
			foreach ($hosts as $host)
				if ($host == gethostname())
					$res = $env;
		}
		return $res;
	}

	public static function getUri() {
		$uri = $_SERVER['REQUEST_URI'];
		$script = $_SERVER['SCRIPT_NAME'];
		$script = str_replace('index.php', '', $script);
		$uri = substr($uri, strlen($script));
		return '/'.$uri;
	}

	public static function getUriPart($i) {
		return explode('/', static::getUri())[$i];
	}

	public function isDebug() {
		return $this->getConfig('debug');
	}

	public function raise($code, $message) {
		http_response_code($code);
		if ($this->isDebug())
			exit('Error '.$code.'<br/>'.$message);
		else
			exit('Error '.$code);
	}

	public function registerAlias($name, $obj) {
		$this->aliases[$name] = $obj;
	}

	public function close() {
		$this->db = null;
	}

}