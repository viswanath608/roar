<?php

function posts() {
	$items = Registry::get('posts');

	if($item = $items->valid()) {
		// register single post
		Registry::set('post', $items->current());

		// move to next
		$items->next();
	}

	return $item;
}

function post_id() {
	return Registry::get('post')->id;
}

function post_title() {
	$post = Registry::get('post');
	$topic = Registry::get('topic');

	return isset($post->title) ? $post->title : (isset($topic->title) ? $topic->title : '');
}

function post_user() {
	$id = Registry::get('post')->user;
	$user = User::find($id);

	return $user->username;
}

function post_user_gravatar($size = 32) {
	$id = Registry::get('post')->user;
	$user = User::find($id);

	return 'http://www.gravatar.com/avatar/' . hash('md5', $user->email) . '/?s=' . $size . '&amp;d=mm';
}

function post_url() {
	$perpage = 10;
	$post = Registry::get('post');

	$count = Post::where('discussion', '=', $post->discussion)->where('id', '<', post_id())->count();
	$page = ceil(++$count / $perpage);

	return base_url('discussion/' . $post->slug . '/' . $page . '/#post-' . post_id());
}

function post_user_url() {
	return base_url('profiles/' . post_user());
}

function post_date($format = null) {
	return Date::relative(Registry::get('post')->date, $format);
}

function post_body() {
	$markdown = new Markdown;
	$body = $markdown->transform(Registry::get('post')->body);

	return $body;
}

function post_report_url() {
	return base_url('report/' . post_id());
}

function post_quote_url() {
	return '#quote-' . post_id();
}