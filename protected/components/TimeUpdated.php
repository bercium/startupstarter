<?php
class TimeUpdated {

	//main function, calling other functions
	//why a seperate function?
	//because we want to build the array in desired depth, and this is the place to do so.
	//also, we wish to keep the main function simple
	public function idea($idea_id){
		$sql = "UPDATE idea SET time_updated = NOW() WHERE id = $idea_id";
 		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
	}
}