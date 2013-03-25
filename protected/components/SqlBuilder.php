<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class SqlBuilder {

	public function idea($type, $filter = 0){
		return true;
	}

	public function translation($filter){
		return true;
	}

	public function user($type, $filter = 0){
		return true;
	}

	public function collabpref($filter){
		return true;
	}

	public function skillset($filter){
		return true;
	}

	public function skill($filter){
		return true;
	}

	public function link($filter){
		return true;
	}
}