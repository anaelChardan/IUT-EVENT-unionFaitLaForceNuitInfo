<?php
/**
 * 
 * Created by Sébastien Morel.
 * Aka: Ananas
 * Date: 12-04-2014
 * Time: 22:33
 * 
 * Copyright ${PROJECT_AUTHOR} 2014
 */
 

namespace App\Models;

use App\Framework\Model;

class Request extends Model {

    public function getCreationDate() {
        return $this->get('creation_date');
    }

    public function getReceptionDate() {
        return $this->get('reception_date');
    }
    public function getProducts() {
        return $this->manyToMany('Product','brigademt_Product_Request','request_id');
    }

    public function getCenter() {
        return $this->manyToOne("CrisisCenter","crisis_center_id");
    }

    public function getPriority() {
        return $this->priority;
    }

} 