<?php
/**
 * Created by PhpStorm.
 * User: corentin
 * Date: 05/12/14
 * Time: 01:59
 */

namespace App\Controllers;

use App\Framework\Controller;
use App\Models\Product;

class ProductController extends Controller {

    public function getProducts(){
        $products= $this->repo('Product')->all();

        return $this->naturalView(["products" =>$products]);
    }

    public function getStats() {
        $productTheMostUp = Product::getTheMostUp();
        $productTheMostDown = Product::getTheMostDown();
        $productTheLessDown = Product::getTheLessDown();
        $productTheLessUp = Product::getTheLessUp();

        return $this->naturalView(["mostup"=>$productTheMostUp, "mostdown"=>$productTheMostDown, "lessup"=>$productTheLessUp, "lessdown"=>$productTheLessDown]);
    }

    public function getProduct() {
        $product = $this->needsEntity('Product','id');
        return $this->naturalView(["product"=>$product]);
    }
} 