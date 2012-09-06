<?php

class Category extends Model {

	public static $table = 'categories';

	public static function slug($str) {
		if($itm = static::where('slug', '=', $str)->fetch()) {
			return new static($itm->id);
		}
	}

	public static function dropdown() {
		$options = array();

		foreach(static::all() as $itm) {
			$options[$itm->id] = $itm->title;
		}

		return $options;
	}

}