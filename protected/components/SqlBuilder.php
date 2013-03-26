<?php
class SqlBuilder {

	//main function, calling other functions
	//why a seperate function?
	//because we want to build the array in desired depth, and this is the place to do so.
	//also, we wish to keep the main function simple
	public function load_array($action, $filter = Array()){

		//current user
		$user_id = Yii::app()->user->id;
		if(!isset($filter['lang'])){
			$filter['lang'] = Yii::app()->language;
		}
		$language = Language::Model()->findByAttributes( array( 'language_code' => $filter['lang'] ) );
		$filter['lang'] = $language->id;

		switch ($action) {
			//frontpage controller
		    case "recent_candidates":
		        return $this->idea("recent", $filter);
		        break;
		    case "recent_users":
		        return $this->user("recent", $filter);
		        break;
		    //idea related controllers
		    case "idea":
		        return $this->idea("idea", $filter);
		        break;
		    //user related controllers
		    case "user":
		        return $this->idea("user", $filter);
		        break;
		}

	}

	public function idea($type, $filter = 0){
		/*
		types:
		recent (GET RECENT idea)
				filter
					by skillset_id
					by skill_id
					by collab_id
					by available
		user (GET USER'S idea)
				filter
					by user_id
		*/

		if( $type == 'recent'){
			$sql =		"SELECT i.*, ist.name AS status FROM ".
						"`idea` AS i, `idea_translation` AS it, `idea_status` AS ist, `idea_member` AS im, `user_match` AS m ".
						"WHERE i.id = im.idea_id ".
						"AND i.status_id = ist.id ".
						"AND i.deleted = 0 ".
						"AND im.match_id = m.id ".
						"AND m.user_id IS NULL ".
						"AND it.idea_id = i.id ".
						"AND it.language_id = '{$filter['lang']}' ".
						"ORDER BY m.id DESC";
		} elseif( $type == 'user' ) {
			$sql=	"SELECT i.*, ist.name AS status FROM ".
					"`idea` AS i, `idea_status` AS ist, `idea_member` AS im, `user_match` AS m, `user` AS u ".
					"WHERE i.id = im.idea_id ".
					"AND i.status_id = ist.id ".
					"AND i.deleted = 0 ".
					"AND im.match_id = m.id ".
					"AND m.user_id = u.id ".
					"AND u.id = '{$filter['user_id']}' ".
					"ORDER BY i.time_registered DESC";
		} elseif( $type == 'idea' ){
			$sql=	"SELECT i.*, ist.name AS status FROM ".
					"`idea` AS i, `idea_status` AS ist ".
					"WHERE i.id = '{$filter['idea_id']}' ".
					"AND i.status_id = ist.id ".
					"AND i.deleted = 0 ";

			echo $sql;
		}

 		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		//read data, build array, call contained functions
		$array = NULL;
		while(($row=$dataReader->read())!==false) {
			$array[$row['id']] = $row;
			$array[$row['id']]['translation'] = $this->translation( 'match', array('idea_id' => $row['id'], 'lang' => $filter['lang'] ));
			$array[$row['id']]['translations_other'] = $this->translation( 'other', array('idea_id' => $row['id'], 'lang' => $filter['lang'] ));
			$array[$row['id']]['members'] = $this->user( 'members', array('idea_id' => $row['id']));
			$array[$row['id']]['candidates'] = $this->user( 'candidates', array('idea_id' => $row['id']));
		}

		return $array;
	}

	public function translation($type, $filter){

		if($type == 'match'){
			$sql=		"SELECT l.name AS language, l.language_code, it.* FROM ".
						"`idea` AS i,`idea_translation` AS it,`language` AS l ".
						"WHERE i.id = it.idea_id ".
						"AND l.id = it.language_id ".
						"AND it.idea_id = {$filter['idea_id']} ".
						"AND it.language_id = {$filter['lang']}";

			$connection=Yii::app()->db;
			$command=$connection->createCommand($sql);
			$dataReader=$command->query();
			//read data, build array, call contained functions
			$array = NULL;
			while(($row=$dataReader->read())!==false) {
				$array = $row;
			}
		} else {
			$sql=		"SELECT l.name AS language, l.language_code, it.* FROM ".
						"`idea` AS i,`idea_translation` AS it,`language` AS l ".
						"WHERE i.id = it.idea_id ".
						"AND l.id = it.language_id ".
						"AND it.idea_id = {$filter['idea_id']} ".
						"AND it.language_id != {$filter['lang']}";

			$connection=Yii::app()->db;
			$command=$connection->createCommand($sql);
			$dataReader=$command->query();
			//read data, build array, call contained functions
			$array = NULL;
			while(($row=$dataReader->read())!==false) {
				$array = $row;
			}
		}

		return $array;

	}

	public function user($type, $filter = 0){
		/*
		type
			recent
			members
			candidates

		contains //currently hardcoded
			skillset
				skill
			collabpref
		*/

		if( $type == 'recent' ){
			$sql=	"SELECT u.*, m.country_id, m.available, m.city_id, m.user_id, m.id as match_id FROM ".
					"`user` AS u, `user_match` AS m ".
					"WHERE m.user_id = u.id ".
					"AND m.user_id > 0 ".
					"ORDER BY u.create_at DESC";
		} elseif( $type == 'members' ) {
			$sql=	"SELECT u.*, m.country_id, m.available, m.city_id, m.user_id, m.id as match_id FROM ".
					"`idea_member` AS im, ".
					"`user` AS u, `user_match` AS m ".
					"WHERE im.match_id = m.id ".
					"AND m.user_id = u.id ".
					"AND m.user_id > 0 ".
					"AND im.idea_id = '{$filter['idea_id']}' ".
					"ORDER BY im.type DESC";
		} elseif( $type == 'candidates' ) {
			$sql=	"SELECT im.idea_id AS id, m.id as match_id, m.country_id, m.available, m.city_id FROM ".
					"`idea_member` AS im, ".
					"`user` AS u, `user_match` AS m ".
					"WHERE im.match_id = m.id ".
					"AND m.user_id IS NULL ".
					"AND im.idea_id = '{$filter['idea_id']}' ".
					"ORDER BY m.id DESC";
		} elseif( $type == 'user' ) {
			$sql=	"SELECT u.*, m.country_id, m.available, m.city_id, m.user_id, m.id as match_id FROM ".
					"`user` AS u, `user_match` AS m".
					"AND m.user_id = u.id ".
					"AND m.user_id > 0 ".
					"AND u.user_id = '{$filter['user_id']}'";
		}

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		//read data, build array, call contained functions
		$array = NULL;
		while(($row=$dataReader->read())!==false) {
			$array[$row['id']] = $row;
			$array[$row['id']]['collabpref'] = $this->collabpref( array('match_id' => $row['match_id']) );
			$array[$row['id']]['skillset'] = $this->skillset( array('match_id' => $row['match_id']) );
			if($type == 'user'){
				$array[$row['id']]['idea'] = $this->idea( array('user_id' => $filter['user_id']) );
			}
			$array[$row['id']]['link'] = $this->link( array('user_id' => $row['id']) );
		}

		return $array;
	}

	public function collabpref($filter){
		$sql=		"SELECT c.* FROM ".
					"`collabpref` AS c, ".
					"`user_collabpref` AS uc ".
					"WHERE uc.collab_id = c.id ".
					"AND uc.match_id = '{$filter['match_id']}'";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		//read data, build array, call contained functions
		$array = NULL;
		while(($row=$dataReader->read())!==false) {
			$array[$row['id']] = $row;
		}

		return $array;
	}

	public function skillset($filter){
		$sql=		"SELECT ss.* FROM ".
					"`skillset` AS ss, ".
					"`user_skill` AS us ".
					"WHERE ss.id = us.skillset_id ".
					"AND us.match_id = '{$filter['match_id']}'";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		//read data, build array, call contained functions
		$array = NULL;
		while(($row=$dataReader->read())!==false) {
			$array[$row['id']] = $row;
			$array[$row['id']]['skill'] = $this->skill( array('match_id' => $filter['match_id'], 'skillset_id' => $row['id']) );
		}

		return $array;
	}

	public function skill($filter){
		/*
		type
			user_skillset ONLY THIS ONE SUPPORTED NOW
			skillset
		*/
		$sql=		"SELECT s.* FROM ".
					"`skill` AS s, ".
					"`user_skill` AS us ".
					"WHERE s.id = us.skill_id ".
					"AND us.skillset_id = '{$filter['skillset_id']}' ".
					"AND us.match_id = '{$filter['match_id']}'";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		//read data, build array, call contained functions
		$array = NULL;
		while(($row=$dataReader->read())!==false) {
			$array[$row['id']] = $row;
		}

		return $array;
	}

	public function link($filter){
		$sql=		"SELECT l.* FROM ".
					"`link` AS l, ".
					"`user_link` AS ul ".
					"WHERE ul.link_id = l.id ".
					"AND ul.user_id = '{$filter['user_id']}'";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		//read data, build array, call contained functions
		$array = NULL;
		while(($row=$dataReader->read())!==false) {
			$array[$row['id']] = $row;
		}

		return $array;
	}
}