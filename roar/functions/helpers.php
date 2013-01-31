<?php

function base_url($path = '') {
	return Uri::make($path);
}

function base_path() {
	return Config::get('application.url');
}

function theme_url($file = '') {
	return asset('themes/' . Config::get('settings.theme') . '/' . ltrim($file, '/'));
}

function theme_include($file) {
	if(is_readable($path = PATH . 'themes' . DS . Config::get('settings.theme') . DS . ltrim($file, '/') . '.php')) {
		return require $path;
	}
}