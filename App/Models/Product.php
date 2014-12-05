<?php
/**
 * 
 * Created by Sébastien Morel.
 * Aka: Ananas
 * Date: 12-04-2014
 * Time: 22:43
 * 
 * Copyright ${PROJECT_AUTHOR} 2014
 */
 

namespace App\Models;

use App\Framework\Model;
use App\Framework\Repository;

class Product extends Model {

    public function getName() {
        return $this->get('name');
    }

    public function getPrice() {
        return $this->get('price');
    }

    public function getQuantity() {
        return $this->get('quantity');
    }

    public function getThumbsUp() {
        return $this->get('thumbs_up');
    }

    public function getThumbsDown() {
        return $this->get('thumbs_down');
    }

    public function getRequests(){
        return $this->manyToMany('Request','brigademt_Product_Request','product_id');
    }

    public static function getTheMostUp() {
        $repo = new Repository('Product');
        $products = $repo->all();
        $max = new Product();
        foreach( $products as $p) {
            if ( $p->getThumbsUp() > $max->getThumbsUp() )
                $max = $p;
        }
        return $max;
    }

    public static function getTheLessUp() {
        $repo = new Repository('Product');
        $products = $repo->all();
        $max = Product::getTheMostUp();
        foreach( $products as $p) {
            if ( $p->getThumbsUp() < $max->getThumbsUp() )
                $max = $p;
        }
        return $max;
    }

    public function getPercentUp() {
        $numberOfUp = $this->getThumbsUp();
        $total = $numberOfUp + $this->getThumbsDown();
        $percentUp = $numberOfUp * 100 / $total;
        return $percentUp;

    }

    public function getPercentDown() {
        $numberOfDown = $this->getThumbsDown();
        $total = $numberOfDown + $this->getThumbsup();
        $percentDown = $numberOfDown * 100 / $total;
        return $percentDown;
    }

    public static function getTheLessDown() {
        $repo = new Repository('Product');
        $products = $repo->all();
        $max = Product::getTheMostDown();
        foreach( $products as $p) {
            if ( $p->getThumbsDown() < $max->getThumbsDown() )
                $max = $p;
        }
        return $max;
    }

    public static function getTheMostDown() {
        $repo = new Repository('Product');
        $products = $repo->all();
        $min = new Product();
        foreach( $products as $p) {
            if ( $p->getThumbsDown() > $min->getThumbsDown() )
                $min = $p;
        }
        return $min;
    }
} 