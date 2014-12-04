<?php

namespace App\Framework;

class Model {
	private $db;
	protected $table = NULL;
	public $idField = 'id';

	private $isNew = true;

	public $attributes = [];
	protected $exclude = [];

	public function __construct() {
		global $app;
		$this->db = $app->db;
		if ($this->table === NULL) {
			$refl = new \ReflectionClass(get_class($this));
			$this->table = strtolower($refl->getShortName()).'s';
		}
	}

	public function getModelName() {
		$refl = new \ReflectionClass(get_class($this));
		return $refl->getShortName();
	}

	public function hydrate($data) {
		$this->attributes = [];
		foreach ($data as $key=>$val) {
			if (in_array($key, $this->exclude))
				continue;
			$this->attributes[utf8_encode($key)] = utf8_encode($val);
		}
		$this->isNew = false;
	}

	public function id() {
		return $this->attributes[$this->idField];
	}

	public function getIdField() {
		return $this->idField;
	}

	public function getTableName() {
		return $this->table;
	}

	public function get($attr) {
		if (array_key_exists($attr, $this->attributes))
			return $this->attributes[$attr];
	}

	public function __invoke($attr) {
		return $this->get($attr);
	}

	public function __get($name) {
		if (array_key_exists($name, $this->attributes))
			return $this->attributes[$name];
	}

	public function __set($name, $val) {
		$this->attributes[$name] = $val;
	}

	public function saveQuery() {
		if ($this->isNew) {
			$query = "INSERT INTO ".$this->table." (";
			$query .= implode(', ', array_keys($this->attributes));
			$query .= ") VALUES(:";
			$query .= implode(", :", array_keys($this->attributes));
			$query .= ")";
		} else {
			$query = "UPDATE ".$this->table." SET";
			$i = 0;
			foreach ($this->attributes as $attr => $val) {
				if ($attr == $this->idField)
					continue;
				$query .= ($i > 0 ? ',': '').' '.$attr." = :".$attr;
				$i++;
			}
			$query .= " WHERE ".$this->idField." = '".$this->id()."'";
		}
		return $query;
	}
	public function save() {
		
		//return $query;
		return $this->db->success($this->saveQuery(), $this->attributes);
	}

	public function deleteQuery() {
		return 'DELETE FROM '.$this->table.' WHERE '.$this->idField.' = :id';
	}

	public function delete() {
		if ($this->isNew) {
			global $app;
			$app->raise(500, "Unable to delete non-persited entity.");
		}
		return $this->db->success($this->deleteQuery(), ['id'=>$this->id()]);

	}

	protected function oneToOne($model, $field = NULL) {
		$repo = $this->db->repository($model);
			if ($field === NULL)
				$field = strtolower($model).'_id';
			return $repo->find($this->attributes[$field]);
	}

	protected function oneToMany($model, $field = NULL) {
		$repo = $this->db->repository($model);
			if ($field === NULL)
				$field = strtolower($this->getModelName()).'_id';
			return $repo->query()->where($field, $this->id())->get();
	}

	protected function manyToOne($model, $field = NULL) {
		$repo = $this->db->repository($model);
			if ($field === NULL)
				$field = strtolower($model).'_id';
			return $repo->find($this->attributes[$field]);
	}

	protected function manyToMany($model, $table = NULL, $thisField = NULL, $otherField = NULL) {
		$thisModel = $this->getModelName();
		if ($thisField === NULL)
			$thisField = strtolower($thisModel).'_id';
		if ($otherField === NULL)
			$otherField = strtolower($model).'_id';
		if ($table === NULL) {
			if ($model < $thisModel)
				$table = $model.'_'.$thisModel;
			else
				$table = $thisModel.'_'.$model;
		}
		$qb = new QueryBuilder($table);
		$items = $qb->where($thisField, $this->id)->get();
		$ids = [];
		foreach ($items as $item)
			$ids[] = $item[$otherField];
		$repo = $this->db->repository($model);
		$entities =  $repo->findRange($ids);

		// We add the relation's attributes to each entities

		if (count($items) > 0 && count(array_keys($items[0])) > 2) {
			foreach ($items as $item) {
				$otherId = $item[$otherField];
				unset($item[$thisField]);
				unset($item[$otherField]);
				foreach ($entities as $entity) {
					if ($entity->id() == $otherId) {
						foreach ($item as $key => $val) {
							$entity->attributes['__rel'][utf8_encode($key)] = utf8_encode($val);
						}
					}
				}
			}
		}
		//var_dump($entities);
		return $entities; 
	}
}