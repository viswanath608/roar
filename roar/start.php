<?php

/*
	Application preprocessing
*/

// load settings
foreach(DB::table('settings')->get() as $item) {
	$settings[$item->key] = $item->value;
}

Config::set('settings', $settings);

// theme functions
$fi = new FilesystemIterator(APP . 'functions', FilesystemIterator::SKIP_DOTS);

foreach($fi as $file) {
	if($file->isFile() and $file->isReadable() and $file->getExtension() == 'php') {
		require $file->getPathname();
	}
}

// language helper
function __($key, $default = '') {
	return $default;
}

// admin helpers
function asset($path) {
	return Config::get('application.base_url') . 'roar/views/assets/' . ltrim($path, '/');
}

function url($path) {
	return base_url('admin/' . $path);
}

function site() {
	return base_url();
}