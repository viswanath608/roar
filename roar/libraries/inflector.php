<?php

class Inflector {

	public static function pluralise($amount, $plural, $single) {
		return (intval($amount) == 1) ? $single : $plural;
	}

}