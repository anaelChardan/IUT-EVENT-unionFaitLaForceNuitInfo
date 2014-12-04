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
} 