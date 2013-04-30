<?php
class Click {

	//main function, calling other functions
	//why a seperate function?
	//because we want to build the array in desired depth, and this is the place to do so.
	//also, we wish to keep the main function simple
	public function idea($idea_click_id, $user_id = NULL){
		$click = new ClickIdea;
		if($user_id == 0)
			$user_id = NULL;


		$click->setAttributes( array( 'user_id' => $user_id, 'idea_click_id' => $idea_click_id ) );
		$click->save();
	}
	public function user($user_click_id, $user_id = NULL){
		$click = new ClickUser;
		if($user_id == 0)
			$user_id = NULL;

		$click->setAttributes( array( 'user_id' => $user_id, 'user_click_id' => $user_click_id ) );
		$click->save();
	}
}