<?php

/*
	Create topic
*/
Route::get('discussion/create', array('before' => 'auth-user', 'do' => function() {
	Registry::set('categories', new Items(Category::all()));
	$vars['categories'] = Category::dropdown();
	return new Template('discussion_create', $vars);
}));

Route::post('discussion/create', array('before' => 'auth-user', 'do' => function() {
	$markdown = new Markdown;
	$post = $markdown->transform(Input::get('post'));

	$category = Input::get('category');
	$title = Input::get('title');
	$description = Input::get('description');

	$slug = Str::slug($title);
	$now = date('c');

	if(Discussion::slug($slug)) {
		Input::flash();

		Notify::notice('Discussion already exists');

		return Response::redirect('discussion/create');
	}

	// get authed user
	$user = User::find(Auth::user()->id);

	$id = Discussion::create(array(
		'category' => $category,
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
		'discussion' => $id,
		'user' => $user->id,
		'date' => $now,
		'body' => $post
	));

	// increment user post count
	$user->posts += 1;
	$user->save();

	return Response::redirect('discussion/' . $slug);
}));

/*
	View discussion
*/
Route::get(array('discussion/(:any)', 'discussion/(:any)/(:num)'), function($slug, $page = 1) {
	if( ! $discussion = Discussion::slug($slug)) {
		return Response::error(404);
	}

	// increment view count
	$discussion->views += 1;
	$discussion->save();

	// mark discussion viewed or set the viewed date
	if($user = Auth::user()) {
		$query = Query::table('user_discussions')->where('user', '=', $user->id)->where('discussion', '=', $discussion->id);

		if($query->count()) {
			$query->update(array(
				'viewed' => date('c')
			));
		}
		else {
			$query->insert(array(
				'user' => $user->id,
				'discussion' => $discussion->id,
				'viewed' => date('c')
			));
		}
	}

	// paginate posts
	$perpage = 10;

	$query = Post::where('discussion', '=', $discussion->id);
	$count = $query->count();
	$posts = $query->order_by('date')->take($perpage)->skip(($page - 1) * $perpage)->get();

	$url = Uri::make('discussion/' . $discussion->slug);
	$paginator = new Paginator($posts, $count, $page, $perpage, $url);

	// set data for theme functions
	Registry::set('categories', new Items(Category::all()));
	Registry::set('discussion', $discussion);
	Registry::set('category', Category::find($discussion->category));
	Registry::set('posts', new Items($paginator->results));
	Registry::set('paginator', $paginator->links());

	return new Template('discussion');
});

/*
	Post a reply
*/
Route::post('discussion/(:any)', array('before' => 'auth-user', 'do' => function($slug) {
	if( ! $discussion = Discussion::slug($slug)) {
		return Response::error(404);
	}

	$reply = Input::get('reply');

	if(empty($reply)) {
		Notify::error('Please enter your reply');

		// get last page
		$perpage = 10;
		$count = Post::where('discussion', '=', $discussion->id)->count();
		$page = ceil($count / $perpage);

		return Response::redirect('discussion/' . $discussion->slug . '/' . $page);
	}

	$markdown = new Markdown;
	$reply = $markdown->transform($reply);

	// get authed user
	$user = User::find(Auth::user()->id);

	$now = date('c');

	$id = Post::create(array(
		'discussion' => $discussion->id,
		'user' => $user->id,
		'date' => $now,
		'body' => $reply
	));

	// set last post info
	$discussion->lastpost_by = $user->id;
	$discussion->lastpost = $now;

	// increment reply count
	$discussion->replies += 1;

	// update discussion
	$discussion->save();

	// increment user post count
	$user->posts += 1;
	$user->save();

	// get last page
	$perpage = 10;
	$count = Post::where('discussion', '=', $discussion->id)->count();
	$page = ceil($count / $perpage);

	return Response::redirect('discussion/' . $discussion->slug . '/' . $page . '#post-' . $id);
}));

/*
	Up Vote a discussion
*/
Route::get('vote/(:num)', array('before' => 'auth-user', 'do' => function($id) {
	if( ! $discussion = Discussion::find($id)) {
		return Response::error(404);
	}

	// get authed user
	$user = Auth::user();
	$voted = Query::table('user_votes')->where('user', '=', $user->id)->where('discussion', '=', $discussion->id);

	// check if user hasnt voted
	if( ! $voted->count()) {
		// increment votes
		$discussion->votes += 1;
		$discussion->save();

		// add user to votes to stop users voting multiple times
		$voted->insert(array('user' => $user->id, 'discussion' => $discussion->id));
	}
	else {
		Notify::notice('You have already voted on this discussion');
	}

	return Response::redirect('discussion/' . $discussion->slug);
}));