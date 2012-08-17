<?php

class Session {

	public static $instance;

	public static function load() {
		static::start();

		static::$instance->load(Cookie::get(Config::get('session.name')));
	}

	public static function start() {
		static::$instance = new Session\Payload(new Session\Drivers\Database);
	}

	public static function started() {
		return ! is_null(static::$instance);
	}

	public static function instance() {
		if(static::started()) return static::$instance;

		throw new \Exception("A driver must be set before using the session.");
	}

	public static function __callStatic($method, $parameters = array()) {
		return call_user_func_array(array(static::instance(), $method), $parameters);
	}

}