<?php

class Database {

	private $table, $bindings = array(), $where = array();

	private $join = '';

	private $offset, $limit;

	private $sort = array();

	private static $pdo;

	public static $queries = array();

	public function __construct($table) {
		$this->table = $table;
	}

	public static function connect() {
		// config
		$params = Config::get('database');

		// set default mysql port number
		if(empty($params['port'])) {
			$params['port'] = 3306;
		}

		// set default collation
		if(empty($params['collation'])) {
			$params['collation'] = 'utf8_bin';
		}
		
		// build dns string
		$dsn = 'mysql:dbname=' . $params['name'] . ';host=' . $params['host'] . ';port=' . $params['port'];

		// mysql driver options
		$options = array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\' COLLATE ' . $params['collation'],
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
		);

		// try connection
		static::$pdo = new PDO($dsn, $params['username'], $params['password'], $options);
		
		// set error handling to exceptions
		static::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public static function table($table) {
		return new static($table);
	}

	public static function query($sql, $bindings = array()) {
		if(is_null(static::$pdo)) static::connect();

		static::$queries[] = compact('sql', 'bindings');
		
		$stm = static::$pdo->prepare($sql);
		$stm->execute($bindings);
		return $stm;
	}

	public static function wrap($column) {
		// dont wrap star selector
		if($column == '*') return $column;

		// array of columns to select from
		if(is_array($column)) {
			$columns = array();

			foreach($column as $col) {
				$columns[] = static::wrap($col);
			}

			return implode(', ', $columns);
		}

		// wrap nested columns
		return implode('.', array_map(function($item) {return ($item == '*') ? $item : '`' . $item . '`';}, explode('.', $column)));
	}

	public function where($column, $operator, $value) {
		$this->where[] = static::wrap($column) . ' ' . $operator . ' ?';
		$this->bindings[] = $value;

		return $this;
	}

	public function skip($num) {
		$this->offset = $num;
		return $this;
	}

	public function take($num) {
		$this->limit = $num;
		return $this;
	}

	public function sort($col, $dir = 'asc') {
		$this->sort[] = static::wrap($col) . ' ' . $dir;
		return $this;
	}

	private function build() {
		$sql = $this->join;

		if(count($this->where)) {
			$sql .= ' WHERE ' . implode(' AND ', $this->where);
		}

		if(count($this->sort)) {
			$sql .= ' ORDER BY ' . implode(',', $this->sort);
		}

		if($this->limit) {
			$sql .= ' LIMIT ' . $this->limit;

			if($this->offset) {
				$sql .= ' OFFSET ' . $this->offset;
			}
		}

		return $sql;
	}

	public function join($table, $left, $operator, $right, $type = 'INNER') {
		$this->join .= ' ' . $type . ' JOIN ' . static::wrap($table) . ' ON (' . static::wrap($left) . ' ' . $operator . ' ' . static::wrap($right) . ')';
		return $this;
	}

	public function left_join($table, $left, $operator, $right) {
		return $this->join($table, $left, $operator, $right, 'LEFT');
	}

	public function insert($data) {
		$columns = implode(',', array_map(function($column) {
			return Database::wrap($column);
		}, array_keys($data)));

		$placeholders = rtrim(str_repeat('?,', count($data)), ',');
		$bindings = array_values($data);

		$sql = 'INSERT INTO ' . static::wrap($this->table) . ' (' . $columns . ') VALUES (' . $placeholders . ')';
		$stm = static::query($sql, $bindings);

		return $stm->rowCount();
	}

	public function insert_get_id($data) {
		if($this->insert($data)) {
			return static::$pdo->lastInsertId();
		}
	}

	public function update($data) {
		$bindings = array_values($data);

		foreach(array_keys($data) as $column) {
			$update[] = static::wrap($column) . ' = ?';
		}

		$sql = 'UPDATE ' . static::wrap($this->table) . ' SET ' . implode(',', $update) . $this->build();
		$stm = static::query($sql, array_merge($bindings, $this->bindings));

		return $stm->rowCount();
	}

	public function delete() {
		$sql = 'DELETE FROM ' . static::wrap($this->table) . $this->build();
		$stm = static::query($sql, $this->bindings);

		return $stm->rowCount();
	}

	private function select($column) {
		$sql = 'SELECT ' . static::wrap($column) . ' FROM ' . static::wrap($this->table) . $this->build();
		$stm = static::query($sql, $this->bindings);

		return $stm;
	}

	public function col($column) {
		return $this->select($column)->fetchColumn();
	}

	public function fetch($column = '*') {
		return $this->select($column)->fetch();
	}

	public function get($column = '*') {
		return $this->select($column)->fetchAll();
	}

	public function count() {
		$sql = 'SELECT COUNT(*) FROM ' . static::wrap($this->table) . $this->build();
		$stm = static::query($sql, $this->bindings);

		return $stm->fetchColumn();
	}
	
}