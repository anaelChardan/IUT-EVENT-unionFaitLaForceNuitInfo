<?php

namespace App\Framework;

class Repository {
	private $modelName;

	private static $cache = [];

	public function __construct($modelName) {
		$this->modelName = $modelName;
	}

	public function getModelName() {
		return 'App\\Models\\'.$this->modelName;
	}

	public function all() {
		return $this->query()->get();
	}

	public function find($id) {
		global $app;
		$cacheEnabled = $app->getConfig('enable_model_caching');
		if ($cacheEnabled && array_key_exists($this->modelName, static::$cache) && array_key_exists($id, static::$cache[$this->modelName]))
		 	return static::$cache[$this->modelName][$id];
		$name = $this->getModelName();
		$model = new $name();
		$idField = $model->idField;
		$entity = $this->query()->where($idField, $id)->first();
		if ($cacheEnabled && $entity !== NULL) {
			static::$cache[$this->modelName][intval($entity->id())] = $entity;
		}
		return $entity;
	}

	public function findRange($idArray) {
		$name = $this->getModelName();
		$model = new $name();
		$idField = $model->idField;
		$entities = $this->query()->where($model->idField, '('.implode(', ', $idArray).')', 'IN', 'and', true)->get();
		return $entities;
	}

	public function query() {
		$name = $this->getModelName();
		$model = new $name();
		$qb = new QueryBuilder($model->getTableName(), $name);
		return $qb;
	}

	public function create() {
		$name = $this->getModelName();
		$model = new $name();
		return $model;
	}
}