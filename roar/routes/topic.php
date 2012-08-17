<?php

/*
	Create topic
*/
Route::get('topic/create/(:num)', array('before' => 'auth-user', 'do' => function($id) {
	if( ! $forum = Forum::find($id)) {
		return Response::error(404);
	}

	Registry::set('forum', $forum);

	return new Template('topic_create');
}));

Route::post('topic/create/(:num)', array('before' => 'auth-user', 'do' => function($id) {
	if( ! $forum = Forum::find($id)) {
		return Response::error(404);
	}

	$markdown = new Markdown;
	$post = $markdown->transform(Input::get('post'));

	$title = Input::get('title');
	$description = Input::get('description');

	$slug = Str::slug($title);
	$now = date('c');

	// get authed user
	$user = User::find(Auth::user()->id);

	$id = Topic::create(array(
		'forum' => $forum->id,
		'slug' => $slug,

		'created_by' => $user->id,
		'lastpost_by' => $user->id,

		'created' => $now,
		'lastpost' => $now,

		'replies' => 1,

		'title' => $title,
		'description' => $description
	));

	Post::create(array(
		'topic' => $id,
		'user' => $user->id,
		'date' => $now,
		'body' => $post
	));

	// increment user post count
	$user->posts += 1;
	$user->save();

	return Response::redirect('topic/' . $id . '-' . $slug);
}));

/*
	View topic
*/
Route::get(array('topic/(:any)', 'topic/(:any)/(:num)'), function($slug, $page = 1) {

	list($id, $slug) = parse_slug($slug);

	if( ! $topic = Topic::find($id)) {
		return Response::error(404);
	}

	// increment view count
	$topic->views += 1;
	$topic->save();

	// paginate posts
	$perpage = 10;

	$query = Post::where('topic', '=', $topic->id);
	$count = $query->count();
	$posts = $query->sort('date')->take($perpage)->skip(($page - 1) * $perpage)->get();

	$url = Uri::make('topic/' . $topic->id . '-' . $topic->slug);
	$paginator = new Paginator($posts, $count, $page, $perpage, $url);

	// set data for theme functions
	Registry::set('topic', $topic);
	Registry::set('forum', Forum::find($topic->forum));
	Registry::set('posts', new Items($paginator->results));
	Registry::set('paginator', $paginator->links());
	
	return new Template('topic');
});

/*
	Post a reply
*/
Route::post('topic/(:any)', array('before' => 'auth-user', 'do' => function($slug) {

	list($id, $slug) = parse_slug($slug);

	if( ! $topic = Topic::find($id)) {
		return Response::error(404);
	}

	$markdown = new Markdown;
	$reply = $markdown->transform(Input::get('reply'));

	// get authed user
	$user = User::find(Auth::user()->id);

	$now = date('c');

	$id = Post::create(array(
		'topic' => $topic->id,
		'user' => $user->id,
		'date' => $now,
		'body' => $reply
	));

	// set last post info
	$topic->lastpost_by = $user->id;
	$topic->lastpost = $now;

	// increment reply count
	$topic->replies += 1;

	// update topic
	$topic->save();

	// increment user post count
	$user->posts += 1;
	$user->save();

	// get last page
	$perpage = 10;
	$count = Post::where('topic', '=', $topic->id)->count();
	$page = ceil($count / $perpage);

	return Response::redirect('topic/' . $topic->id . '-' . $topic->slug . '/' . $page . '#post-' . $id);
}));

/*
	Up Vote a topic
*/
Route::get('vote/(:num)', array('before' => 'auth-user', 'do' => function($id) {
	if( ! $topic = Topic::find($id)) {
		return Response::error(404);
	}

	$topic->votes += 1;
	$topic->save();

	return Response::redirect('topic/' . $topic->id . '-' . $topic->slug);
}));