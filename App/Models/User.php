<?php

namespace App\Models;

use App\Framework\Model;

class User extends Model {

	public function __construct() {
		parent::__construct();
		//$this->oneToOneRelation('profile', 'Profile');
	}

	public function profile() {
		return $this->oneToOne('Profile');
	}

	public function posts() {
		return $this->oneToMany('Post');
	}

	public function genres() {
		return $this->manyToMany('Genre', 'Genre_User', 'Code_User', 'Code_Genre');
	}

}