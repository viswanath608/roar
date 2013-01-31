<?php

Route::filter('auth', function() {
	if(Auth::guest()) {
		return Response::redirect('admin/login');
	}
	else {
		$user = Auth::user();

		if($user->role != 'administrator') return Response::redirect('admin/login');
	}
});

Route::filter('auth-user', function() {
	if(Auth::guest()) {
		Notify::error('Please login to continue');

		return Response::redirect('/');
	}
});

Route::filter('csrf', function() {
	if( ! Csrf::check(Input::get('token'))) {
		Notify::error(array('Invalid token'));

		return Response::redirect('admin/login');
	}
});