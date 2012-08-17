<?php

function base_url($path = '') {
	$url = Config::get('application.base_url');

	if($index = Config::get('application.index_page')) {
		$url .= $index . '/';
	}

	return $url . trim($path, '/');
}

function base_path() {
	return Config::get('application.base_url');
}

function theme_url($file = '') {
	return base_path() . 'themes/' . Config::get('settings.theme') . '/' . ltrim($file, '/');
}

function theme_include($file) {
	if(is_readable($path = PATH . 'themes' . DS . Config::get('settings.theme') . DS . ltrim($file, '/') . '.php')) {
		return require $path;
	}
}

function parse_slug($str) {
	$parts = explode('-', $str);

	return array(array_shift($parts), implode('-', $parts));
}
