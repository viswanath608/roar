<?php

function search_results() {
	$items = Registry::get('search_results');

	if($item = $items->valid()) {	
		// register single post
		Registry::set('post', $items->current());
		
		// move to next
		$items->next();
	}

	return $item;
}

function search_has_results() {
	$items = Registry::get('search_results');

	return ($items) ? $items->length() : false;
}

function search_paging() {
	return Registry::get('paginator');
}