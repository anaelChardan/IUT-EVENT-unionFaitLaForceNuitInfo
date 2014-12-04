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

    public function getRequests(){
        return $this->manyToMany('Request','brigademt_Product_Request','product_id');
    }
} 