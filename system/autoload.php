<?php

class Autoloader {

	private static $mappings = array();
	private static $directories = array();

	public static function register() {
		spl_autoload_register(array('Autoloader', 'load'));
	}
	
	public static function unregister() {
		spl_autoload_unregister(array('Autoloader', 'load'));
	}

	public static function map($map) {
		static::$mappings = array_merge(static::$mappings, $map);
	}

	public static function directory($dir) {
		static::$directories = array_merge(static::$directories, $dir);
	}
	
	public static function load($class) {
		// does the class have a direct map
		if(isset(static::$mappings[$class])) {
			return require static::$mappings[$class];
		}

		$file = str_replace(array('//', '\\'), '/', trim(strtolower($class), '/'));

		// search directories
		if($path = static::find($file)) {
			return require $path;
		}

		return false;
	}
	
	public static function find($file) {
		foreach(static::$directories as $path) {
			// normalise path
			$path = rtrim($path, DS) . DS;

			if(is_readable($path . $file . '.php')) {
				return $path . $file . '.php';
			}
		}
		
		return false;
	}

}
