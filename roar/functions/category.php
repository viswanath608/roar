<?php

function categories() {
	$items = Registry::get('categories');

	if($item = $items->valid()) {
		// register single post
		Registry::set('category', $items->current());

		// move to next
		$items->next();
	}

	return $item;
}

function category_id() {
	return Registry::get('category')->id;
}

function category_title() {
	return Registry::get('category')->title;
}

function category_description() {
	return Registry::get('category')->description;
}

function category_slug() {
	return Registry::get('category')->slug;
}

function category_url() {
	return base_url(category_slug());
}

function category_post_count() {
	return Registry::get('category')->posts;
}

function category_paging() {
	return Registry::get('paginator');
}