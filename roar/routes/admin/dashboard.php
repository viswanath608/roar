<?php

/*
	Main welcome page
*/
Route::get('admin/dashboard', array('before' => 'auth', 'do' => function() {
	$vars['messages'] = Notify::read();
	$vars['token'] = Csrf::token();

	return View::make('dashboard', $vars)
		->nest('header', 'partials/header')
		->nest('footer', 'partials/footer');
}));