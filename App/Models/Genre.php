<?php

namespace App\Models;

use App\Framework\Model;

class Genre extends Model {

	protected $table = "Genre";
	public $idField = "Code_Genre";

	public function libele() {
		return $this->get('Libellé_Abrégé');
	}

}