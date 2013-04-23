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
		//echo "SQLBUILDER:$action<br/>";
		//print_r($filter);
		switch ($action) {
			//frontpage controller
		    case "recent_candidate":
		        return $this->idea("recent", $filter);
		        break;
		    case "recent_user":
		        return $this->user("recent", $filter);
		        break;
		    //idea related controllers
		    case "idea":
		    	if(isset($filter['idea_id'])){
		        return $this->idea("idea", $filter);
		        }
		        break;
		    //user related controllers
		    case "user":
		        return $this->user("user", $filter);
		        break;
		}

	}

	public function idea($type, $filter = 0){
		//echo "IDEA QUERIED:$type<br/>";
		//print_r($filter);
		if( $type == 'recent'){
			$sql =	"SELECT i.*, ist.name AS status FROM ".
					"`idea` AS i, `idea_translation` AS it, `idea_status` AS ist, `idea_member` AS im, `user_match` AS m ".
					"WHERE i.id = im.idea_id ".
					"AND i.status_id = ist.id ".
					"AND i.deleted = 0 ".
					"AND im.match_id = m.id ".
					"AND m.user_id IS NULL ".
					"AND it.idea_id = i.id ".
					"AND it.language_id = '{$filter['lang']}' ".
					"AND it.deleted = 0 ".
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
		} elseif( $type == 'usercount' ) {
			$sql=	"SELECT count(im.idea_id) AS count FROM ".
					"`idea_member` AS im, `idea` AS i ".
					"WHERE i.id = im.idea_id ".
					"AND i.deleted = 0 ".
					"AND im.match_id = '{$filter['match_id']}' ".
					"GROUP BY im.idea_id";
		} elseif( $type == 'idea' ){
			$sql=	"SELECT i.*, ist.name AS status FROM ".
					"`idea` AS i, `idea_status` AS ist ".
					"WHERE i.id = '{$filter['idea_id']}' ".
					"AND i.status_id = ist.id ".
					"AND i.deleted = 0 ";
		}
//echo $sql."\n";

 		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		//read data, build array, call contained functions
		$array = NULL;
		while(($row=$dataReader->read())!==false) {
			
			if($type == "usercount"){
				$array = $row['count'];
			} else {
				//prepare filter
				$filter['idea_id'] = $row['id'];

				//add data to array
				//$row['']
				$row = array_merge($row, $this->translation( 'userlang', $filter ));
					$filter['default_lang'] = $row['language_id'];
				$row['translation_other'] = $this->translation( 'other', $filter );
				$row['member'] = $this->user( 'member', $filter );
				$row['candidate'] = $this->user( 'candidate', $filter );

				//what kind of an
				if($type != 'idea'){
					$array[$row['id']] = $row;
				} else {
					$array = $row;
				}
				//print_r($row);
			}

		}

		return $array;
	}

	public function translation($type, $filter){
		//echo "TRANSLATION QUERIED:$type<br/>";
		//print_r($filter);
		if($type == 'userlang'){
			$sql=		"SELECT it.id AS translation_id, it.title, it.pitch, it.description, it.description_public, it.tweetpitch, it.language_id, l.name AS language, l.language_code FROM ".
						"`idea` AS i,`idea_translation` AS it,`language` AS l ".
						"WHERE i.id = it.idea_id ".
						"AND l.id = it.language_id ".
						"AND it.deleted = 0 ".
						"AND it.idea_id = {$filter['idea_id']} ".
						"ORDER BY FIELD(it.language_id, '{$filter['lang']}') DESC LIMIT 1";

			$connection=Yii::app()->db;
			$command=$connection->createCommand($sql);
			$dataReader=$command->query();
			//read data, build array, call contained functions
			$array = NULL;
			while(($row=$dataReader->read())!==false) {
				$array = $row;
				//print_r($row);
			}
		} else {
			$sql=		"SELECT it.*, l.name AS language, l.language_code FROM ".
						"`idea` AS i,`idea_translation` AS it,`language` AS l ".
						"WHERE i.id = it.idea_id ".
						"AND l.id = it.language_id ".
						"AND it.idea_id = {$filter['idea_id']} ".
						"AND it.language_id != {$filter['default_lang']}";

			$connection=Yii::app()->db;
			$command=$connection->createCommand($sql);
			$dataReader=$command->query();
			//read data, build array, call contained functions
			$array = NULL;
			while(($row=$dataReader->read())!==false) {
				$array[$row['id']] = $row;
				//print_r($row);
			}
		}
		//echo $sql."\n";

		return $array;

	}

	public function user($type, $filter = 0){
		//echo "USER QUERIED:$type<br/>";
		//print_r($filter);
		if( $type == 'recent' ){
			$sql=	"SELECT m.id, u.id AS user_id, u.email, u.create_at, u.lastvisit_at, u.superuser, u.status, u.name, u.surname, u.address, u.avatar_link, u.language_id, u.newsletter, ".
					"m.country_id, m.city_id, m.available, a.name AS available_name FROM ".
					"`user` AS u, `user_match` AS m, `available` AS a ".
					"WHERE m.user_id = u.id ".
					"AND m.user_id > 0 ".
					"ORDER BY u.create_at DESC";
		} elseif( $type == 'member' ) {
			$sql=	"SELECT m.id, im.type_id, mt.name AS type, u.id AS user_id, u.email, u.create_at, u.lastvisit_at, u.superuser, u.status, u.name, u.surname, u.address, u.avatar_link, u.language_id, u.newsletter, ".
					"m.country_id, m.city_id, m.available, a.name AS available_name FROM ".
					"`idea_member` AS im, `membertype` AS mt, ".
					"`user` AS u, `user_match` AS m, `available` AS a ".
					"WHERE im.match_id = m.id ".
					"AND m.user_id = u.id ".
					"AND m.user_id > 0 ".
					"AND im.idea_id = '{$filter['idea_id']}' ".
					"AND (im.type_id = '2' || im.type_id = '1') ". //HARDCODED MEMBER TYPE
					"AND im.type_id = mt.id ".
					"ORDER BY im.type_id ASC";
		} elseif( $type == 'candidate' ) {
			$sql=	"SELECT m.id, im.type_id, mt.name AS type, ".
					"m.country_id, m.available, m.city_id, a.name AS available_name FROM ".
					"`idea_member` AS im, `user_match` AS m, `membertype` AS mt, `available` AS a ".
					"WHERE im.match_id = m.id ".
					"AND m.user_id IS NULL ".
					"AND im.idea_id = '{$filter['idea_id']}' ".
					"AND im.type_id = '3' ". //HARDCODED CANDIDATE
					"AND im.type_id = mt.id ".
					"ORDER BY m.id DESC";
		} elseif( $type == 'user' ) {
			$sql=	"SELECT m.id, u.id AS user_id, u.email, u.create_at, u.lastvisit_at, u.superuser, u.status, u.name, u.surname, u.address, u.avatar_link, u.language_id, u.newsletter, ".
					"m.country_id, m.city_id, m.available, a.name AS available_name FROM ".
					"`user` AS u, `user_match` AS m, `available` AS a ".
					"WHERE m.user_id = u.id ".
					"AND m.user_id > 0 ".
					"AND u.id = '{$filter['user_id']}'";
		}
		//echo $sql."\n";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		//read data, build array, call contained functions
		$array = NULL;
		while(($row=$dataReader->read())!==false) {
			
			//print_r($row);
			
			//set filter
			$filter['match_id'] = $row['id'];

			//add data to array
			if($type == 'user'){
				//show complete list of available collabprefs when pulling user data
				$row['collabpref'] = $this->collabpref( 'combined', $filter );
			} else {
				//show only existing collabprefs
				$row['collabpref'] = $this->collabpref( 'existing', $filter );
			}

			if(isset($filter['skillset_mode'])){
				$row['skillset'] = $this->skillset( $filter );
			} else {
				$row['skill'] = $this->skill( $filter );
			}
				
			if($type == 'user'){
				$row['idea'] = $this->idea( "user", $filter );
				$row['num_of_ideas'] = count($row['idea']);
			}
			if($type == 'recent'){
				$row['num_of_ideas'] = $this->idea( "usercount", $filter );
			}
			if($type != 'candidate'){
				$filter['uid'] = $row['user_id'];
				$row['link'] = $this->link( $filter );
			}

			//is it one to one or one to many array?
			if( $type != 'user' ){
				$array[$row['id']] = $row;
			} else {
				$array = $row;
			}

		}

		return $array;
	}

	public function collabpref($type, $filter){
		//echo "COLLABPREF QUERIED:$type<br/>";
		//print_r($filter);
		if($type == 'combined'){
			$sql=	"SELECT uc.id, collabpref.id AS collab_id, collabpref.name, uc.id AS active ".
					"FROM collabpref LEFT JOIN ".
					"(SELECT * FROM user_collabpref WHERE match_id = 2) AS uc ".
					"ON uc.collab_id = collabpref.id";
		} else {
			$sql=	"SELECT uc.id, c.id AS collab_id, c.name FROM ".
					"`collabpref` AS c, ".
					"`user_collabpref` AS uc ".
					"WHERE uc.collab_id = c.id ".
					"AND uc.match_id = '{$filter['match_id']}'";
		}
		//echo $sql."\n";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		//read data, build array, call contained functions
		$array = NULL;
		while(($row=$dataReader->read())!==false) {
			$array[$row['id']] = $row;
			//print_r($row);
		}

		return $array;
	}

	public function skill($filter){
		//echo "SKILL QUERIED:<br/>";
		//print_r($filter);
		$sql=		"SELECT us.id, us.skillset_id, ss.name AS skillset, us.skill_id, s.name AS skill FROM ".
					"`user_skill` AS us, ".
					"`skillset` AS ss, ".
					"`skill` AS s ".
					"WHERE ss.id = us.skillset_id AND s.id = us.skill_id ".
					"AND us.match_id = '{$filter['match_id']}'";
//echo $sql."\n";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		//read data, build array, call contained functions
		$array = NULL;
		while(($row=$dataReader->read())!==false) {
			$array[$row['id']] = $row;
			//print_r($row);
		}
		return $array;
	}

	public function skillset($filter){
		//echo "SKILLSET QUERIED:<br/>";
		//print_r($filter);
		$sql=		"SELECT ss.id, ss.name AS skillset FROM ".
					"`user_skill` AS us, ".
					"`skillset` AS ss ".
					"WHERE ss.id = us.skillset_id ".
					"AND us.match_id = '{$filter['match_id']}' ".
					"GROUP BY ss.id";
//echo $sql."\n";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		//read data, build array, call contained functions
		$array = NULL;
		while(($row=$dataReader->read())!==false) {
			$filter['skillset_id'] = $row['id'];

			$array[$row['id']] = $row;
			$array[$row['id']]['skill'] = $this->skillset_skill( $filter );
			//print_r($row);
		}

		return $array;
	}
	public function skillset_skill($filter){
		//echo "SKILLSETSKILL QUERIED:<br/>";
		//print_r($filter);
		$sql=		"SELECT s.id, s.name AS skill FROM ".
					"`user_skill` AS us, ".
					"`skill` AS s ".
					"WHERE s.id = us.skill_id ".
					"AND us.skillset_id = '{$filter['skillset_id']}' ";
					"AND us.match_id = '{$filter['match_id']}'";
//echo $sql."\n";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		//read data, build array, call contained functions
		$array = NULL;

		while(($row=$dataReader->read())!==false) {
			$array[$row['id']] = $row;
			//print_r($row);
		}
		return $array;
	}

	public function link($filter){
		//echo "LINK QUERIED:<br/>";
		//print_r($filter);
		$sql=		"SELECT ul.* FROM ".
					"`user_link` AS ul ".
					"WHERE ul.user_id = '{$filter['uid']}'";
//echo $sql."\n";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		//read data, build array, call contained functions
		$array = NULL;

		while(($row=$dataReader->read())!==false) {
			$array[$row['id']] = $row;
			//print_r($row);
		}

		return $array;
	}
}