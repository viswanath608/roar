<?php

class Config {

	private static $items = array();
	private static $cache = array();

	/*
		Load the default config file
	*/
	public static function load($name) {
		$path = APP . 'config' . DS . $name . '.php';

		if(is_readable($path)) {
			static::$items[$name] = require $path;
		}
	}
	
	/*
		Set a config item
	*/
	public static function set($key, $value) {
		// array pointer for search
		$array =& static::$items;

		$keys = explode('.', $key);

		while(count($keys) > 1) {
			$key = array_shift($keys);

			if(!isset($array[$key]) or !is_array($array[$key])) {
				$array[$key] = array();
			}

			$array =& $array[$key];
		}

		$array[array_shift($keys)] = $value;
	}
	
	/*
		Retrive a config param
	*/
	public static function get($key, $default = false) {
		// return cached
		if(isset(static::$cache[$key])) {
			return static::$cache[$key];
		}

		// load config file
		$segments = explode('.', $key);
		$config = $segments[0];

		if(empty(static::$items[$config])) static::load($config);

		// copy array for search
		$array = static::$items;

		// search array
		foreach($segments as $segment) {
			if(!is_array($array) or array_key_exists($segment, $array) === false) {
				return $default;
			}

			$array = $array[$segment];
		}

		// cache it for faster lookups
		static::$cache[$key] = $array;

		return $array;
	}

	/*
		Remove a config param
	*/
	public static function forget($key) {
		// array pointer for search
		$array =& static::$items;

		$keys = explode('.', $key);

		while(count($keys) > 1) {
			$key = array_shift($keys);

			if(!isset($array[$key]) or !is_array($array[$key])) {
				return;
			}

			$array =& $array[$key];
		}

		unset($array[array_shift($keys)]);
	}

}