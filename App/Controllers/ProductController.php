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
    public function getIndex(){
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

    public function postThumbUp() {
        $product = $this->needsEntity('Product','id');
        $product->thumbsUpIncremente();
        $product->save();
        return $this->redirect('Product', 'product', ['id'=>$product->id()]);
    }

    public function postThumbDown() {
        $product = $this->needsEntity('Product','id');
        $product->thumbsDownIncremente();
        $product->save();
        return $this->redirect('Product', 'product', ['id'=>$product->id()]);
    }

    public function getNew() {
        return $this->naturalView();
    }

    public function postNew() {
        $product = new Product();

        $product->name = $this->request->name;
        $product->quantity = $this->request->quantity;
        $product->price = $this->request->price;
        $product->thumbs_up = 0;
        $product->thumbs_down = 0;

        $product->save();

        return $this->redirect('Product', 'product', ['id'=>$product->id()]);
    }

    public function getEdit() {
        $product = $this->needsEntity('Product', 'id');
        return $this->naturalView(['product'=>$product]);
    }

    public function postEdit() {
        $product = $this->needsEntity('Product', 'id');

        $product->name = $this->request->name;
        $product->quantity = $this->request->quantity;
        $product->price = $this->request->price;

        $product->save();

        return $this->redirect('Product', 'product', ['id'=>$product->id()]);
    }
} 