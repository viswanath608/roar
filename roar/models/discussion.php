<?php

class Discussion extends Model {

	public static $table = 'discussions';

	public static function slug($str) {
		if($itm = static::where('slug', '=', $str)->fetch()) {
			return new static($itm->id);
		}
	}

}