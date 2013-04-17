<?php
class Click {

	//main function, calling other functions
	//why a seperate function?
	//because we want to build the array in desired depth, and this is the place to do so.
	//also, we wish to keep the main function simple
	public function idea($user_id, $idea_click_id){
		$click = new ClickIdea;
		$click->setAttributes( array( 'user_id' => $user_id, 'idea_click_id' => $idea_click_id ) );
		$click->save();

		echo "YEAI";
	}
	public function user($user_id, $user_click_id){
		$click = new ClickUser;
		$click->setAttributes( array( 'user_id' => $user_id, 'user_click_id' => $user_click_id ) );
		$click->save();
		echo "YEAU";
	}
}