<?php

namespace App\Models;

use App\Framework\Model;

class Post extends Model {

	public function __construct() {
		parent::__construct();
	}

	public function author() {
		return $this->manyToOne('User');
	}

}