<?php

/*
	Search
*/
Route::get('search', function() {
	return new Template('search');
});

Route::post('search', function() {
	$term = Input::get('query');

	$id = hash('crc32', $term);
	$results = array();

	// search topics
	$perpage = 10;
/*
	$query = Query::table('topics')
		->join('posts', 'posts.topic', '=', 'topics.id')
		->where('title', 'like', $term . '%')
		->or_where('posts.body', 'like', $term . '%')
		->take($perpage * 10);
*/

	$query = Query::table('posts')
		->where('body', 'like', '%' . $term . '%')
		->take($perpage * 10);

	if($query->count()) {
		foreach($query->get('posts.id') as $post) {
			$results[] = $post->id;
		}
	}

	Session::put($id, $results);
	
	return Response::redirect('search/' . $id);
});

/*
	View results
*/
Route::get(array('search/(:any)', 'search/(:any)/(:num)'), function($id, $page = 1) {
	$results = Session::get($id);

	$perpage = 10;

	$posts = Query::table('posts')
		->join('discussions', 'discussions.id', '=', 'posts.discussion')
		->where_in('posts.id', $results)
		->take($perpage)
		->skip(($page - 1) * $perpage)
		->get(array('posts.*', 'discussions.title', 'discussions.slug'));

	$count = Query::table('posts')
		->join('discussions', 'discussions.id', '=', 'posts.discussion')
		->where_in('posts.id', $results)
		->count();

	$url = Uri::make('search/' . $id);

	$paginator = new Paginator($posts, $count, $page, $perpage, $url);

	Registry::set('search_results', new Items($paginator->results));

	Registry::set('paginator', $paginator->links());

	return new Template('search');
});