<?php

function forums() {
	$items = Registry::get('forums');

	if($item = $items->valid()) {	
		// register single post
		Registry::set('forum', $items->current());
		
		// move to next
		$items->next();
	}

	return $item;
}

function forum_name() {
	return Config::get('settings.forum_name');
}

function forum_id() {
	return Registry::get('forum')->id;
}

function forum_title() {
	return Registry::get('forum')->title;
}

function forum_description() {
	return Registry::get('forum')->description;
}

function forum_slug() {
	return Registry::get('forum')->slug;
}

function forum_url() {
	return base_url() . 'forum/' . forum_id() . '-' . forum_slug();
}