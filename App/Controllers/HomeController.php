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

    public function getStats() {
        $productTheMostUp = Product::getTheMostUp();
        $productTheMostDown = Product::getTheMostDown();
        $productTheLessDown = Product::getTheLessDown();
        $productTheLessUp = Product::getTheLessUp();



        return $this->naturalView(["mostup"=>$productTheMostUp, "mostdown"=>$productTheMostDown, "lessup"=>$productTheLessUp, "lessdown"=>$productTheLessDown]);
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

    public function getProduct() {
        $product = $this->needsEntity('Product','id');
        return $this->naturalView(["product"=>$product]);
    }
}

?>