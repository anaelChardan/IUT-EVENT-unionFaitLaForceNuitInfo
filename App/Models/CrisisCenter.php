<?php
/**
 * 
 * Created by Sébastien Morel.
 * Aka: Ananas
 * Date: 12-04-2014
 * Time: 22:42
 * 
 * Copyright ${PROJECT_AUTHOR} 2014
 */
 

namespace App\Models;

use App\Framework\Model;

class CrisisCenter extends Model {
	protected $table = "brigademt_crisis_centers";
    public function getName(){
        return $this->get('name');
    }
}