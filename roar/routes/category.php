<?php

/*
	View Index
*/
Route::get(array('/', 'discussions', 'discussions/(:num)'), function($page = 1) {
	Registry::set('categories', new Items(Category::all()));

	$user = Auth::user();
	$perpage = 10;

	$select = 'select discussions.*';
	$sql = ' from discussions';
	$bindings = array();

	if($user) {
		$bindings[] = $user->id;
		$select = 'select discussions.*, user_discussions.viewed';
		$sql = ' from discussions
			left join (select * from user_discussions where user = ?) as user_discussions
			on (user_discussions.discussion = discussions.id)';
	}

	$count = DB::column('select count(*)' . $sql, $bindings);

	$results = DB::query($select . $sql . ' order by votes desc, lastpost desc
		limit ' . $perpage . ' offset ' . (($page - 1) * $perpage), $bindings);

	$paginator = new Paginator($results, $count, $page, $perpage, Uri::make('discussions') . '/');

	Registry::set('discussions', new Items($paginator->results));
	Registry::set('paginator', $paginator->links());

	return new Template('index');
});

/*
	View category
*/
Route::get(array('category/(:any)', 'category/(:any)/(:num)'), function($slug, $page = 1) {
	if( ! $category = Category::slug($slug)) {
		return Response::error(404);
	}

	Registry::set('categories', new Items(Category::all()));
	Registry::set('category', $category);

	$user = Auth::user();
	$perpage = 10;
	$offset = ($page - 1) * $perpage;

	$count = Query::table(Discussion::$table)->where('category', '=', $category->id)->count();

	$sql = 'select discussions.*, user_discussions.viewed
		from discussions
		left join user_discussions on (user_discussions.discussion = discussions.id)
		where discussions.category = ?
		and (user_discussions.user = ? or user_discussions.user is null)
		order by votes desc, lastpost desc
		limit ' . $perpage . ' offset ' . $offset;

	$results = DB::query($sql, array($category->id, ($user ? $user->id : 0)));

	$paginator = new Paginator($results, $count, $page, $perpage, Uri::make('category/' . $category->slug));

	Registry::set('discussions', new Items($paginator->results));
	Registry::set('paginator', $paginator->links());

	return new Template('category');
});