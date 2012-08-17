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
	$query = DB::table('topics')
		->join('posts', 'posts.topic', '=', 'topics.id')
		->where('title', 'like', $term . '%')
		->or_where('posts.body', 'like', $term . '%')
		->take($perpage * 10);
*/
	$query = DB::table('posts')
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

	$sql = 'select posts.*, topics.title, topics.slug from posts 
		join topics on (topics.id = posts.topic) 
		where posts.id in (' . implode(',', $results) . ')
		limit ' . $perpage . ' offset ' . (($page - 1) * $perpage);

	$query = DB::query($sql);

	$sql = 'select count(*) from posts 
		join topics on (topics.id = posts.topic) 
		where posts.id in (' . implode(',', $results) . ')';

	$count = DB::query($sql);

	$url = Uri::make('search/' . $id);

	$paginator = new Paginator($query->fetchAll(), $count->fetchColumn(), $page, $perpage, $url);

	Registry::set('search_results', new Items($paginator->results));

	Registry::set('paginator', $paginator->links());

	return new Template('search');
});