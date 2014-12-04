<?php

namespace App\Controllers;

use App\Framework\Controller;

class HomeController extends Controller {
	public function getIndex() {
		//var_dump($res);
		$user = $this->repo('User')->find(1);
		$title = $user->profile()->title;
		return $this->naturalView(["text"=>"Utilisateurs", "user"=>$user, "title"=>$title]);
	}

	public function getForm() {
		return $this->naturalView(["adding"=>true]);
	}

	public function postForm() {
		return "Bonjour ".$this->request->name;
	}

	public function getUser() {
		return $this->needsEntity('User', 'id')->username;
	}

	public function getAuth() {
		return Auth::getModel();
	}
}

?>