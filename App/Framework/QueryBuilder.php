<?php

namespace App\Framework;

class QueryBuilder {
	protected $tableName;
	protected $modelName;

	protected $fields = ['*'];
	protected $wheres = [];
	protected $orders = [];

	protected $params = [];

	function __construct($tableName, $modelName = '') {
		$this->tableName = $tableName;
		$this->modelName = $modelName;
	}

	public function where($field, $value, $operator = '=', $link = 'and', $noParam = false) {
		$clause = compact('field', 'value', 'operator', 'link', 'noParam');
		$this->wheres[] = $clause;
		return $this;
	}

	public function orWhere($field, $value, $operator = '=', $noParam = false) {
		$link = 'or';
		$clause = compact('field', 'value', 'operator', 'link', 'noParam');
		$this->wheres[] = $clause;
		return $this;
	}

	public function orderBy($field, $sort = 'ASC') {
		$this->orders[] = compact('field', 'sort');
		return $this;
	}

	public function select($mixed) {
		if (is_array($mixed))
			$this->field = $mixed;
		else if (is_string($mixed))
			$this->field = [$mixed];
	}

	private function whereClause() {
		if (count($this->wheres) == 0)
			return "";

		$res = "";
		foreach ($this->wheres as $clause) {
			if ($res != '') {
				$res .= ' '.strtoupper($clause['link']).' ';
			}
			if ($clause['noParam']) {
				$res .= $clause['field'].' '.$clause['operator']." ".$clause['value'];
			} else {
				$this->params[$clause['field']] = $clause['value'];
				$res .= $clause['field'].' '.$clause['operator']." :".$clause['field'];
			}
		}
		return ' WHERE '.$res;
	}

	private function orderClause() {
		if (count($this->orders) == 0)
			return "";

		$res = "";
		foreach ($this->orders as $clause) {
			if ($res != '') {
				$res .= ', ';
			}
			$res .= $clause['field'].' '.$clause['sort'];
		}
		return ' ORDER BY '.$res;
	}

	public function get() {
		global $app;
		$query = "SELECT * FROM ".$this->tableName;
		$query .= $this->whereClause();
		$query .= $this->orderClause();
		$res =  $app->db->execute($query, $this->params);
		if ($this->modelName == '')
			return $res;
		$objs = [];
		foreach ($res as $data) {
			$obj = new $this->modelName();
			$obj->hydrate($data);
			$objs[] = $obj;
		}

		return $objs;
	}

	public function first() {
		global $app;
		$query = "SELECT * FROM ".$this->tableName;
		$query .= $this->whereClause();
		$query .= $this->orderClause();
		$res =  $app->db->first($query, $this->params);
		if ($this->modelName == '')
			return $res;

		if ($res === NULL)
			return NULL;

		$obj = new $this->modelName();
		$obj->hydrate($res);
		return $obj;

	}

	public function count() {
		global $app;
		$query = "SELECT COUNT(*) FROM ".$this->tableName;
		$query .= $this->whereClause();
		$res =  $app->db->count($query, $this->params);
		if ($this->modelName == '')
			return $res;

	}

}