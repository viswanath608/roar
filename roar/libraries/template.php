<?php

class Template extends View {

	public function __construct($template, $vars = array()) {
		$this->path = PATH . 'themes' . DS . Config::get('settings.theme') . DS . $template . '.php';

		if( ! is_readable($this->path)) {
			throw new Exception("Template not found: " . $template);			
		}

		$this->vars = array_merge($this->vars, $vars);
	}
	
}