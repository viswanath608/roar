<?php

function discussions() {
	$items = Registry::get('discussions');

	if($item = $items->valid()) {	
		// register single post
		Registry::set('discussion', $items->current());
		
		// move to next
		$items->next();
	}

	return $item;
}

function discussion_id() {
	return Registry::get('discussion')->id;
}

function discussion_votes() {
	return Registry::get('discussion')->votes;
}

function discussion_vote_url() {
	return base_url() . 'vote/' . discussion_id();
}

function discussion_replies() {
	return Registry::get('discussion')->replies;
}

function discussion_views() {
	return Registry::get('discussion')->views;
}

function discussion_unread() {
	if(Auth::guest()) return false;

	$discussion = Registry::get('discussion');

	if( ! is_null($discussion->viewed)) {
		return strtotime($discussion->viewed) < strtotime($discussion->lastpost);
	}

	return true;
}

function discussion_created_by() {
	return User::find(Registry::get('discussion')->created_by)->username;
}

function discussion_created_by_url() {
	return base_url() . 'profiles/' . discussion_created_by();
}

function discussion_created() {
	return Date::format(Registry::get('discussion')->created);
}

function discussion_lastpost_by() {
	return User::find(Registry::get('discussion')->lastpost_by)->username;
}

function discussion_lastpost_by_url() {
	return base_url() . 'profiles/' . discussion_lastpost_by();
}

function discussion_lastpost() {
	return Date::format(Registry::get('discussion')->lastpost);
}

function discussion_title() {
	return Registry::get('discussion')->title;
}

function discussion_description() {
	return Registry::get('discussion')->description;
}

function discussion_slug() {
	return Registry::get('discussion')->slug;
}

function discussion_url() {
	return base_url() . 'discussion/' . discussion_slug();
}

function discussion_create_url() {
	return base_url() . 'discussion/create';
}

function discussion_paging() {
	return Registry::get('paginator');
}