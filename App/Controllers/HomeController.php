<?php

namespace App\Controllers;

use App\Framework\Controller;
use App\Models\Product;

class HomeController extends Controller {
	public function getIndex() {
		//var_dump($res);
		$centers = $this->repo('CrisisCenter')->all();
		
		return $this->naturalView(["centers"=>$centers]);
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