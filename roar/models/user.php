<?php

class User extends Model {

	public static $table = 'users';

	public static function search($params = array()) {
		$query = DB::table(static::$table);

		foreach($params as $key => $value) {
			$query->where($key, '=', $value);
		}

		return $query->fetch();
	}

}