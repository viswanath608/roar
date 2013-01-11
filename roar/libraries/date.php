<?php

class Date {

	protected static function time($str) {
		if(is_numeric($str)) return $str;

		if(($time = strtotime($str)) === false) {
			throw new InvalidArgumentException('Invalid date string [' . $str . ']');
		}

		return $time;
	}

	public static function format($date, $format = null) {
		if(is_null($format)) $format = Config::get('settings.date_format');

		return date($format, static::time($date));
	}

	public static function relative($date, $format = null) {
		$time = static::time($date);
		$diff = abs(time() - $time);

		if($diff > 172800) { // 2 days
			return static::format($time, $format);
		}

		if($diff > 86400) { // 1 day
			return date('H:i', $time) . ' Yesterday';
		}

		if($diff > 43200) { // 12 hours
			return date('H:i', $time) . ' Today';
		}

		if($diff > 21600) { // 6 hours
			return date('H:i', $time);
		}

		if($diff > 3600) { // 1 hour
			return ceil($diff / 3600) . ' hours ago';
		}

		if($diff > 60) { // 1 min
			return ceil($diff / 60) . ' minutes ago';
		}

		return 'Just now';
	}

}