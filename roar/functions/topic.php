<?php

function topics() {
	$items = Registry::get('topics');

	if($item = $items->valid()) {	
		// register single post
		Registry::set('topic', $items->current());
		
		// move to next
		$items->next();
	}

	return $item;
}

function topic_id() {
	return Registry::get('topic')->id;
}

function topic_votes() {
	return Registry::get('topic')->votes;
}

function topic_vote_url() {
	return base_url() . 'vote/' . topic_id();
}

function topic_replies() {
	return Registry::get('topic')->replies;
}

function topic_views() {
	return Registry::get('topic')->views;
}

function topic_created_by() {
	return User::find(Registry::get('topic')->created_by)->username;
}

function topic_created_by_url() {
	return base_url() . 'profiles/' . topic_created_by();
}

function topic_created() {
	return Date::format(Registry::get('topic')->created);
}

function topic_lastpost_by() {
	return User::find(Registry::get('topic')->lastpost_by)->username;
}

function topic_lastpost_by_url() {
	return base_url() . 'profiles/' . topic_lastpost_by();
}

function topic_lastpost() {
	return Date::format(Registry::get('topic')->lastpost);
}

function topic_title() {
	return Registry::get('topic')->title;
}

function topic_description() {
	return Registry::get('topic')->description;
}

function topic_slug() {
	return Registry::get('topic')->slug;
}

function topic_url() {
	return base_url() . 'topic/' . topic_id() . '-' . topic_slug();
}

function topic_create_url() {
	return base_url() . 'topic/create/' . forum_id();
}

function topic_paging() {
	return Registry::get('paginator');
}

function topic_has_tags() {
	return false;
}

function topic_tags() {
	return '';
}