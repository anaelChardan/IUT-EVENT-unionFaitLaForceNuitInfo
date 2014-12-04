<?php 

namespace App\Framework;

class Controller {
	public $request;
	protected $app;

	function __construct($request) {
		$this->request = $request;
		$this->app = $this->request->app;
	}

	public function __get($attr) {
		return $this->app->$attr;
	}

	public function view($name, $vars = []) {
		global $twig;
		echo $twig->render($name, $vars);
	}

	public function naturalView($vars = []) {
		$ctlName = $this->request->getApplication()->getControllerName();
		$actionName = $this->request->getApplication()->getRawActionName();
		return $this->view($ctlName.'/'.$actionName.'.html.twig', $vars);
	}

	public function repo($name) {
		return $this->app->db->repository($name);
	}

	public function needs($param, $fallback = NULL) {
		if ($fallback === NULL) {
			$fallback = function() use ($param) {
				global $app;
				$app->raise(500, 'The parameter "'.$param.'" is needed.');
			};
		}

		if (!Input::has($param))
			$fallback();
	}

	public function needsOrDefault($param, $default) {
		if (!Input::has($param))
			Input::push($param, $default);
	}

	public function needsEntity($model, $param) {
		$this->needs($param);
		$id = $this->request->$param;
		return $this->repo($model)->find($id);
	}
}