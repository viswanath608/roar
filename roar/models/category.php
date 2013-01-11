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

	public static function all() {
		$sql = 'select categories.*, coalesce(sum(discussions.replies), 0) as posts from categories
			left join discussions on (discussions.category = categories.id)
			group by discussions.category';

		return DB::query($sql);
	}

}