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

function post_url() {
	$perpage = 10;
	$post = Registry::get('post');

	$count = Post::where('topic', '=', $post->topic)->where('id', '<', post_id())->count();
	$page = ceil(++$count / $perpage);

	return base_url() . 'topic/' . $post->topic . '-' . $post->slug . '/' . $page . '/#post-' . post_id();
}

function post_user_url() {
	return base_url() . 'profiles/' . post_user();
}

function post_date() {
	return Date::format(Registry::get('post')->date);
}

function post_body() {
	return Registry::get('post')->body;
}

function post_report_url() {
	return base_url() . 'report/' . post_id();
}

function post_quote_url() {
	return '#quote-' . post_id();
}