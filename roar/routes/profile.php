<?php

/*
	View user profile
*/
Route::get('profiles/(:any)', function($username) {
	if( ! $user = User::search(array('username' => $username))) {
		return Response::error(404);
	}

	// get last 4 posts
	$posts = Post::where('user', '=', $user->id)
		->join('discussions', 'discussions.id', '=', 'posts.discussion')
		->order_by('date', 'desc')
		->take(4)
		->get(array('posts.*', 'discussions.slug', 'discussions.title'));

	Registry::set('user', $user);
	
	Registry::set('recent_posts', new Items($posts));

	return new Template('profile');
});