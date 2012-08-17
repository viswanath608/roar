<?php

/*
	Report post
*/
Route::get('report/(:num)', array('before' => 'auth-user', 'do' => function($id) {

	if( ! $post = Post::find($id)) {
		return Response::error(404);
	}

	// get authed user
	$user = Auth::user();

	// report post
	if(DB::table('post_reports')->where('post', '=', $post->id)->where('user', '=', $user->id)->count()) {
		Notify::notice('Post has already been reported for moderation');
	}
	else {
		DB::table('post_reports')->insert(array('post' => $post->id, 'user' => $user->id));

		Notify::notice('Post has been reported for moderation');
	}

	$perpage = 10;

	$count = Post::where('topic', '=', $post->topic)->where('id', '<', $post->id)->count();
	$page = ceil(++$count / $perpage);

	$uri = 'topic/' . $post->topic . '-' . $post->slug . '/' . $page;

	return Response::redirect($uri);
}));