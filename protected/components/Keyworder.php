<?php
class Keyworder {

	//a function to convert a string to an array, with normalized values (no special characters)
	//why a seperate function?
	//because it is used more than one time, and we want the programmers to be aware of it
	public function string2array($string){

		$string = $this->clean($string);
		$array = explode(", ", $string);
		
		return $array;
	}

	public function clean($string){

		// Strip HTML Tags
		$clear = strip_tags($string);
		// Clean up things like &amp;
		$clear = html_entity_decode($clear);
		// Strip out any url-encoded stuff
		$clear = urldecode($clear);
		// Replace non-AlNum characters with space
		//$clear = preg_replace('/[^A-Za-z0-9]/', '', $clear);
		// Replace Multiple spaces with single space
		$clear = preg_replace('/ +/', ' ', $clear);
		// Trim the string of leading/trailing space
		$clear = trim($clear);

		return $clear;
	}
}