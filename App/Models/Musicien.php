<?php

namespace App\Models;

use App\Framework\Model;

class Musicien extends Model {

	protected $table = "Musicien";
	public $idField = "Code_Musicien";

	public function getNom() {
		return $this->get('Nom_Musicien');
	}

	public function interprete() {
		return $this->manyToMany('Oeuvre', 'Composer', 'Code_Musicien', 'Code_Oeuvre');
	}

}