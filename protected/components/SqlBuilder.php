<?php
/*TODO:
-search: keyword input validation
-bug: skills sentence fucked up? recheck sentences*/

class SqlBuilder {
	//main function, calling other functions
	//why a seperate function?
	//because we want to build the array in desired depth, and this is the place to do so.
	//also, we wish to keep the main function simple
	public function load_array($action, $filter = Array()){

	//INPUT VALUES VALIDATE
	//NOTE: $_GET values get transmitted to this class. All values must be checked
		if(isset($filter['page']) && !is_numeric($filter['page']))
			$filter['page'] = 1;
		if(isset($filter['per_page']) && !is_numeric($filter['per_page'])){
			if(isset($_GET['ajax'])){
				$filter['per_page'] = 3;
			} else {
				$filter['per_page'] = 12;
			}
		}

	//SET DEFAULT VALUES
		$user_id = Yii::app()->user->id;
		if(!isset($filter['lang'])){
			$filter['lang'] = Yii::app()->language;
		}
		$language = Language::Model()->findByAttributes( array( 'language_code' => $filter['lang'] ) );
		$filter['lang'] = $language->id;

		if(!isset($filter['page']))
			$filter['page'] = 1;
		if(!isset($filter['per_page'])){
			if(isset($_GET['ajax'])){
				$filter['per_page'] = 3;
			} else {
				$filter['per_page'] = 12;
			}
		}

		$filter['action'] = $action;

	//SEARCH SETUP
		

	//WHICH ACTION IS PERFORMED?
		switch ($action) {
			//frontpage controller
		    case "recent_updated":
		    	return $this->idea("recent_updated", $filter);
		        break;
		    case "recent_candidate":
		    	return $this->idea("recent_candidate", $filter);
		        break;
		    case "recent_user":
		        return $this->user("recent", $filter);
		        break;
		    //search function
		    case "search_idea":
		    	return $this->search("idea", $filter);
		    case "search_user":
		    	return $this->search("user", $filter);
		    //idea related data
		    case "idea":
		    	if(isset($filter['idea_id'])){
		        	return $this->idea("idea", $filter);
		        }
		        break;
		    //user related data
		    case "user":
		    	if(isset($filter['user_id'])){
		        	return $this->user("user", $filter);
		        }
		        break;
		    //pagination data
		    case "count_idea":
		    	return $this->idea("count_idea", $filter);
		        break;
		    case "count_user":
		    	return $this->user("count_user", $filter);
		        break;
		}

	}

	public function idea($type, $filter, $data = array()){

		if( $type == 'recent_candidate'){
			$sql =	"SELECT i.*, ist.name AS status FROM ".
					"`idea` AS i, `idea_status` AS ist, `idea_member` AS im, `user_match` AS m ".
					"WHERE i.id = im.idea_id ".
					"AND i.status_id = ist.id ".
					"AND i.deleted = 0 ".
					"AND im.match_id = m.id ".
					"AND m.user_id IS NULL ".
					"AND it.deleted = 0 ".
					"ORDER BY m.id DESC ".
					"LIMIT ". ($filter['page'] - 1) * $filter['per_page'] .", ". ($filter['per_page']);

		} elseif( $type == 'recent_updated' ) {
			$sql =	"SELECT i.*, ist.name AS status FROM ".
					"`idea` AS i, `idea_status` AS ist ".
					"WHERE i.deleted = 0 ".
					"AND ist.id = i.status_id ".
					"ORDER BY i.time_updated DESC ".
					"LIMIT ". ($filter['page'] - 1) * $filter['per_page'] .", ". ($filter['per_page']);

		} elseif( $type == 'user' ) {
			$sql=	"SELECT i.*, ist.name AS status, im.type_id FROM ".
					"`idea` AS i, `idea_status` AS ist, `idea_member` AS im ".
					"WHERE i.id = im.idea_id ".
					"AND i.status_id = ist.id ".
					"AND i.deleted = 0 ".
					"AND im.match_id = '{$filter['match_id']}' ".
					"ORDER BY i.time_registered DESC";

		} elseif( $type == 'idea' ){
			$sql=	"SELECT i.*, ist.name AS status FROM ".
					"`idea` AS i, `idea_status` AS ist ".
					"WHERE i.id = '{$filter['idea_id']}' ".
					"AND i.status_id = ist.id ".
					"AND i.deleted = 0 ";

		} elseif( $type == 'count_idea' ){
			//for pagination
			$sql =	"SELECT count(i.id) as count FROM ".
					"`idea` AS i ".
					"WHERE i.deleted = 0 ";

		} elseif( $type == 'count_clicks' ){
			$sql =	"SELECT count(ci.id) as count FROM ".
					"`click_idea` AS ci ".
					"WHERE ci.idea_click_id = '{$filter['idea_id']}' ".
					"GROUP BY idea_click_id";

		} elseif( $type == 'search' ){
			$sql =	"SELECT i.*, ist.name AS status FROM ".
					"`idea` AS i, `idea_status` AS ist ".
					"WHERE i.deleted = 0 ".
					"AND ist.id = i.status_id ".
					"AND ( ";

			$keys = array();
			foreach( $data AS $key => $value ){
				$condition[] =	"i.id = {$value['id']}";
				$keys[] = $value['id'];
			}
			$sql.= implode($condition, " OR ") . " ) ORDER BY FIELD(i.id, ".implode($keys, ', ').") ASC";
		}

 		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$array = array();

		while(($row=$dataReader->read())!==false) {
			
			if($type == "count_idea"){
				$array['num_of_rows'] = $row['count'];
				$array['filter'] = $filter;
			} elseif($type == "count_clicks"){
				$array = $row['count'];
			} else {
				//prepare filter
				$filter['idea_id'] = $row['id'];

				//translation..
				$merge = $this->translation( 'userlang', $filter );
				if(isset($merge['language_id'])){
					$row = array_merge($row, $merge);
					$filter['default_lang'] = $merge['language_id'];
				} else {
					$filter['default_lang'] = $filter['lang'];
				}

				if($type != 'user'){
					$row['translation_other'] = $this->translation( 'other', $filter );
					$row['member'] = $this->user( 'member', $filter );
					$row['num_of_members'] = count($row['member']);
					$row['candidate'] = $this->user( 'candidate', $filter );
					$row['date_updated'] = Yii::app()->dateFormatter->formatDateTime(strtotime($row['time_updated']));
					$row['days_updated'] = round( (strtotime($row['time_updated']) - time()) / 86400 , 0, PHP_ROUND_HALF_DOWN ) * -1;	
				}

				//add number of clicks
				if($filter['action'] == ('user' || 'idea')){
					$row['num_of_clicks'] = $this->idea('count_clicks', $filter);
				}

				//multi record array, or not?
				if($type != 'idea'){
					$array[$row['id']] = $row;
				} else {
					$array = $row;
				}
			}
		}

		return $array;
	}

	public function translation($type, $filter){

		if($type == 'userlang'){
			$sql=		"SELECT it.id AS translation_id, it.title, it.pitch, it.description, it.description_public, it.tweetpitch, it.language_id, l.name AS language, l.language_code FROM ".
						"`idea` AS i,`idea_translation` AS it,`language` AS l ".
						"WHERE i.id = it.idea_id ".
						"AND l.id = it.language_id ".
						"AND it.deleted = 0 ".
						"AND it.idea_id = {$filter['idea_id']} ".
						"ORDER BY FIELD(it.language_id, '{$filter['lang']}') DESC";

		} else {
			$sql=		"SELECT it.*, l.name AS language, l.id AS language_id FROM ".
						"`idea` AS i,`idea_translation` AS it,`language` AS l ".
						"WHERE i.id = it.idea_id ".
						"AND l.id = it.language_id ".
						"AND it.deleted = 0 ".
						"AND it.idea_id = {$filter['idea_id']} ".
						"AND it.language_id != {$filter['default_lang']}";

		}

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$array = array();
		while(($row=$dataReader->read())!==false) {
			//multi record array, or not?
			if($type == 'userlang'){
				$array = $row;
			} else {
				$array[$row['id']] = $row;
			}
		}

		return $array;

	}

	public function user($type, $filter = 0, $data = array()){

		if( $type == 'user' ) {
			//return specific user's data
			$sql=	"SELECT m.id AS match_id, ".
					"u.id AS id, u.email, u.create_at, u.lastvisit_at, u.superuser, u.status, ".
					"u.name, u.surname, u.address, u.avatar_link, u.language_id, u.newsletter, ".
					"l.name AS language, c.name AS country, ci.name AS city, m.country_id, m.city_id, ".
					"m.available, a.name AS available_name FROM ".
					"`user_match` AS m ".
					"LEFT JOIN `user` AS u ON m.user_id = u.id ".
					"LEFT JOIN `available` AS a ON a.id = m.available ".
					"LEFT JOIN `country` AS c ON c.id = m.country_id ".
					"LEFT JOIN `city` AS ci ON ci.id = m.city_id ".
					"LEFT JOIN `language` AS l ON u.language_id = l.id ".
					"WHERE m.user_id > 0 AND u.id = '{$filter['user_id']}'";

		} elseif( $type == 'recent' ){
			//return recently registered users' data
			$sql=	"SELECT m.id AS match_id, ".
					"u.id AS id, u.email, u.create_at, u.lastvisit_at, u.superuser, u.status, ".
					"u.name, u.surname, u.address, u.avatar_link, u.language_id, u.newsletter, ".
					"l.name AS language, c.name AS country, ci.name AS city, m.country_id, m.city_id, ".
					"m.available, a.name AS available_name FROM ".
					"`user_match` AS m ".
					"LEFT JOIN `user` AS u ON m.user_id = u.id ".
					"LEFT JOIN `available` AS a ON a.id = m.available ".
					"LEFT JOIN `country` AS c ON c.id = m.country_id ".
					"LEFT JOIN `city` AS ci ON ci.id = m.city_id ".
					"LEFT JOIN `language` AS l ON u.language_id = l.id ".
					"WHERE m.user_id > 0 ".
					"ORDER BY u.create_at DESC ".
					"LIMIT ". ($filter['page'] - 1) * $filter['per_page'] .", ". $filter['per_page'];

		} elseif( $type == 'member' ) {
			//return members of an idea
			$sql=	"SELECT m.id AS match_id, im.type_id, mt.name AS type, ".
					"u.id AS id, u.email, u.create_at, u.lastvisit_at, u.superuser, u.status, ".
					"u.name, u.surname, u.address, u.avatar_link, u.language_id, u.newsletter, ".
					"l.name AS language, c.name AS country, ci.name AS city, m.country_id, m.city_id, ".
					"m.available, a.name AS available_name FROM ".
					"`idea_member` AS im ".
					"LEFT JOIN `user_match` AS m ON im.match_id = m.id ".
					"LEFT JOIN `user` AS u ON m.user_id = u.id ".
					"LEFT JOIN `membertype` AS mt ON im.type_id = mt.id ".
					"LEFT JOIN `available` AS a ON a.id = m.available ".
					"LEFT JOIN `country` AS c ON c.id = m.country_id ".
					"LEFT JOIN `city` AS ci ON ci.id = m.city_id ".
					"LEFT JOIN `language` AS l ON u.language_id = l.id ".
					"WHERE m.user_id > 0 ".
					"AND im.idea_id = '{$filter['idea_id']}' ".
					"AND (im.type_id = '2' || im.type_id = '1') ". //HARDCODED MEMBER TYPE
					"ORDER BY im.type_id ASC";

		} elseif( $type == 'candidate' ) {
			//return candidates of an idea
			$sql=	"SELECT m.id AS match_id, im.type_id, mt.name AS type, ".
					"c.name AS country, ci.name AS city, m.country_id, m.city_id, ".
					"m.available, a.name AS available_name FROM ".
					"`idea_member` AS im ".
					"LEFT JOIN `user_match` AS m ON im.match_id = m.id ".
					"LEFT JOIN `membertype` AS mt ON im.type_id = mt.id ".
					"LEFT JOIN `available` AS a ON a.id = m.available ".
					"LEFT JOIN `country` AS c ON c.id = m.country_id ".
					"LEFT JOIN `city` AS ci ON ci.id = m.city_id ".
					"WHERE m.user_id IS NULL ".
					"AND im.idea_id = '{$filter['idea_id']}' ".
					"AND im.type_id = '3' ". //HARDCODED CANDIDATE
					"ORDER BY m.id DESC";

		} elseif($type == 'count_user'){
			//for pagination
			$sql=	"SELECT count(u.id) AS count FROM ".
					"`user` AS u ";

		} elseif( $type == 'search' ){

			$sql=	"SELECT m.id AS match_id, ".
					"u.id AS id, u.email, u.create_at, u.lastvisit_at, u.superuser, u.status, ".
					"u.name, u.surname, u.address, u.avatar_link, u.language_id, u.newsletter, ".
					"l.name AS language, c.name AS country, ci.name AS city, m.country_id, m.city_id, ".
					"m.available, a.name AS available_name FROM ".
					"`user_match` AS m ".
					"LEFT JOIN `user` AS u ON m.user_id = u.id ".
					"LEFT JOIN `available` AS a ON a.id = m.available ".
					"LEFT JOIN `country` AS c ON c.id = m.country_id ".
					"LEFT JOIN `city` AS ci ON ci.id = m.city_id ".
					"LEFT JOIN `language` AS l ON u.language_id = l.id ".
					"WHERE m.user_id > 0 ".
					"AND ( ";



			$keys = array();
			foreach( $data AS $key => $value ){
				$condition[] =	"m.id = {$value['id']}";
				$keys[] = $value['id'];
			}
			$sql.= implode($condition, " OR ") . " ) ORDER BY FIELD(m.id, ".implode($keys, ', ').") ASC";
		}


		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$array = array();

		while(($row=$dataReader->read())!==false) {
			
			if($type == "count_user"){
				$array['num_of_rows'] = $row['count'];
				if($type == "count_user"){
					$array['filter'] = $filter;
				}
			} else {
				//set filter
				$filter['match_id'] = $row['match_id'];

				//collabpref data
				if($type == 'user'){
					//show complete list of available collabprefs when pulling user data
					$row['collabpref'] = $this->collabpref( 'combined', $filter );
				} else {
					//show only existing collabprefs
					$row['collabpref'] = $this->collabpref( 'normal', $filter );
				}

				//user's ideas, add and count
				$row['idea'] = $this->idea('user', $filter);
				$i = 0;
				if(count($row['idea']) > 0){
					foreach($row['idea'] AS $key => $value)
						$i++;
				}
				$row['num_of_rows'] = $i;

				//skillset
				$row['skillset'] = $this->skillset( $filter );
				
				//add link
				if($type != 'candidate'){
					$filter['uid'] = $row['id'];
					$row['link'] = $this->link( $filter );
				}

				//is it one to one or one to many array?
				if( $type != 'user' ){
					if( $type == 'candidate'){
						$array[$row['match_id']] = $row;
					} else {
						$array[$row['id']] = $row;
					}
				} else {
					$array = $row;
				}

			}
		}

		return $array;
	}

	public function collabpref($type, $filter){

		if($type == 'combined'){
			$sql=	"SELECT uc.id, collabpref.id AS collab_id, collabpref.name, uc.id AS active ".
					"FROM collabpref LEFT JOIN ".
					"(SELECT * FROM user_collabpref WHERE match_id = {$filter['match_id']}) AS uc ".
					"ON uc.collab_id = collabpref.id";
		} else {
			$sql=	"SELECT uc.id, c.id AS collab_id, c.name FROM ".
					"`collabpref` AS c, ".
					"`user_collabpref` AS uc ".
					"WHERE uc.collab_id = c.id ".
					"AND uc.match_id = '{$filter['match_id']}'";
		}

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$array = array();

		while(($row=$dataReader->read())!==false) {
			$array[$row['id']] = $row;
		}

		return $array;
	}

	public function skillset($filter){

		$sql=		"SELECT ss.id, ss.name AS skillset FROM ".
					"`user_skill` AS us, ".
					"`skillset` AS ss ".
					"WHERE ss.id = us.skillset_id ".
					"AND us.match_id = '{$filter['match_id']}' ".
					"GROUP BY ss.id";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$array = array();

		while(($row=$dataReader->read())!==false) {
			$filter['skillset_id'] = $row['id'];

			$array[$row['id']] = $row;
			$array[$row['id']]['skill'] = $this->skillset_skill( $filter );
		}

		return $array;
	}

	public function skillset_skill($filter){

		$sql=		"SELECT s.id, s.name AS skill FROM ".
					"`user_skill` AS us, ".
					"`skill` AS s ".
					"WHERE s.id = us.skill_id ".
					"AND us.skillset_id = '{$filter['skillset_id']}' ";
					"AND us.match_id = '{$filter['match_id']}'";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$array = array();

		while(($row=$dataReader->read())!==false) {
			$array[$row['id']] = $row;
		}
		return $array;
	}

	public function link($filter){

		$sql=		"SELECT ul.* FROM ".
					"`user_link` AS ul ".
					"WHERE ul.user_id = '{$filter['uid']}'";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$array = array();

		while(($row=$dataReader->read())!==false) {
			$array[$row['id']] = $row;
		}

		return $array;
	}

	public function search($type, $filter){

		/*Taking in from $filter[] and processing data into sql;
		There's more than one user_match row per idea... We'll group by user_match, to preserve best match
		
		Input data structure (word is table, -field is $key)

		idea_keyword ---($k rows) -> $filter['keyword'][N]['key'];
			-keyword

		idea -> $filter['extra'];
			-website
			-video_link
		
		idea_status -> $filter['status'];
			-status_id

		user_match -> $filter['$key'];
			-country_id
			-city_id
			-available

		user_collabpref ---($c rows) -> $filter['collabpref'][N]['key'];
			-collab_id

		user_skill  ---($ss rows) -> $filter['skill'][N]['key'];
			-id
			-type=1

		user_skill  ---($s rows) -> $filter['skill'][N]['key'];
			-id
			-type=2*/

		/*Data preprocessing*/
		if( isset($filter['skill']) ){
			foreach($filter['skill'] AS $key => $value){
				if($value['type'] == '1')
					$filter['skillset'][] = $value['id']; //skillset_id
				if($value['type'] == '2')
					$filter['skillset_skill'][] = $value['id']; //skillset_skill's id
			}
		}
		if( isset($filter['keyword']) ){
			$keyworder = new Keyworder;
			$filter['keyword'] = $keyworder->string2array($filter['keyword']);
		}

		/*SQL query processing (idea data, grouped by candidates)*/
		
		if($type == "idea"){
			$sql = "SELECT i.id AS id, ";
		} elseif($type == "user") {
			$sql = "SELECT m.id AS id, ";
		}

		/*FIELDS TO PULL*/

		if($type == "idea"){
			//keyword AS k
			if( isset($filter['keyword']) && count($filter['keyword']) > 0 ){
				$k = -1;
				foreach($filter['keyword'] AS $key => $value){
					$k++;
					$sql.= "k{$k}.id AS k{$k}_id, ";
				}
			}

			//idea AS i
			if(isset($filter['status_id']) AND is_numeric($filter['status_id'])){
				$sql.=	"is.status_id, ";
			}
			if(isset($filter['extra'])){
				$sql.=	"i.website, 
						i.video_link, ";
			}
		}

		//user_match AS m
		if(isset($filter['country_id']) AND is_numeric($filter['country_id'])){
			$sql.=	"m.country_id, ";
		}
		if(isset($filter['city_id']) AND is_numeric($filter['city_id'])){
			$sql.=	"m.city_id, ";
		}
		if(isset($filter['available']) AND is_numeric($filter['available'])){
			$sql.=	"m.available, ";
		}

		//user_collabpref AS c
		if( isset($filter['collabpref']) && count($filter['collabpref']) > 0 ){
			$c = -1;
			foreach($filter['collabpref'] AS $key => $value){
				if(is_numeric($value)){
					$c++;
					$sql.= "c{$c}.id AS c{$c}_id, ";
				}
			}
		}

		//user_skill (skillset) AS ms
		if( isset($filter['skillset']) && count($filter['skillset']) > 0 ){
			$ms = -1;
			foreach($filter['skillset'] AS $key => $value){
				if(is_numeric($value)){
					$ms++;
					$sql.= "ms{$s}.id AS ms{$s}_id, ";
				}
			}
		}
		//user_skill (skillset_skill) AS mss
		if( isset($filter['skillset_skill']) && count($filter['skillset_skill']) > 0 ){
			$mss = -1;
			foreach($filter['skillset_skill'] AS $key => $value){
				if(is_numeric($value)){
					$mss++;
					$sql.= "mss{$mss}.id AS mss{$mss}_id, ";
				}
			}
		}

		$sql.= "'200' AS status ";

		if($type == "idea"){
			$sql.= "FROM `idea` AS i 
					LEFT JOIN `idea_member` AS im ON 
						i.id = im.idea_id 
						AND im.type_id = 3 
					LEFT JOIN `user_match` AS m ON 
						m.id = im.match_id ";
		} elseif($type == "user") {
			$sql.= "FROM `user_match` AS m ";
		}

		/*TABLES TO LEFT JOIN*/
		//at the same time we are also preparing $cols for result ranking

		$cols = array();

		if($type == "idea"){
			//idea_keyword AS k
			if( isset($filter['keyword']) && count($filter['keyword']) > 0 ){
				$k = -1;
				foreach($filter['keyword'] AS $key => $value){
					//$VALUE INPUT VALIDATION NEEDED
					$k++;
					$sql.= "LEFT JOIN `keyword` AS k{$k} ON 
								k{$k}.table = 'idea' 
								AND k{$k}.row_id = i.id 
								AND k{$k}.keyword = :k{$k}_id ";
					$cols["k{$k}_id"] = $value; //this key is an _id here, but it's really a string
				}
			}

			//idea AS i
			//the following field does not require joins, we're merely preparing variables for result ranking
			if(isset($filter['status_id']) AND is_numeric($filter['status_id'])){
				$cols["status_id"] = $filter['status_id'];
			}
			if(isset($filter['extra'])){
				$cols["website"] = "";
				$cols["video_link"] = "";
			}
		}

		//user_match AS m
		//the following fields do not require joins, we're merely preparing variables for result ranking
		if(isset($filter['country_id']) AND is_numeric($filter['country_id'])){
			$cols["country_id"] = $filter['country_id'];
		}
		if(isset($filter['city_id']) AND is_numeric($filter['city_id'])){
			$cols["city_id"] = $filter['city_id'];
		}
		if(isset($filter['available']) AND is_numeric($filter['available'])){
			$cols["available"] = $filter['available'];
		}

		//user_collabpref AS c
		if( isset($filter['collabpref']) && count($filter['collabpref']) > 0 ){
			$c = -1;
			foreach($filter['collabpref'] AS $key => $value){
				if(is_numeric($value)){
					$c++;
					$sql.= "LEFT JOIN `user_collabpref` AS c{$c} ON 
								c{$c}.id = m.collab_id 
								AND c{$c}.id = :c{$c}_id";
					$cols["c{$c}_id"] = $value;
				}
			}
		}

		//user_skill (skillset) AS ms
		if( isset($filter['skillset']) && count($filter['skillset']) > 0 ){
			$ms = -1;
			foreach($filter['skillset'] AS $key => $value){
				if(is_numeric($value)){
					$ms++;
					$sql.= "LEFT JOIN `user_skill` AS ms{$ms} ON 
								ms{$ms}.match_id = m.id 
								AND ms{$ms}.skillset_id = :ms{$ms}_id ";
					$cols["ms{$ms}_id"] = $value;
				}
			}
		}
		//user_skill (skillset_skill) AS mss
		if( isset($filter['skillset_skill']) && count($filter['skillset_skill']) > 0 ){
			$mss = -1;
			foreach($filter['skillset_skill'] AS $key => $value){
				if(is_numeric($value)){
					$mss++;
					$sql.= "LEFT JOIN `skillset_skill` AS ss{$mss} ON 
								ss{$mss}.id = :mss{$mss}_id 
							LEFT JOIN `user_skill` AS mss{$mss} ON 
								mss{$mss}.match_id = m.id 
								AND mss{$mss}.skillset_id = ss{$mss}.skillset_id 
								AND mss{$mss}.skill_id = ss{$mss}.skill_id ";
					$cols["mss{$mss}_id"] = $value;
				}
			}
		}

		if($type == "idea") {
			//group by idea_id
			//because it's highly relevant if one person has skills sought in several candidates
			$sql.=	"GROUP BY i.id";
		} elseif($type == "user") {
			$sql.=	"WHERE m.user_id > 0 
					GROUP BY m.id";
		}

		/*WE GOT SQL SENTENCE BUILT ($sql), DATA GATHERED ($cols) LETS RUN THIS STUFF*/
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);

		/*BIND COLUMNS TO SQL*/
		$cols_backup = $cols;
		foreach($cols as $col =>  &$value){ // $value can be changed by the body of foreach loop.
			if($col != 'status_id' && $col != 'country_id' && $col != 'city_id' && $col != 'available')
				$command->bindParam(":{$col}", $value);
		}
		$dataReader=$command->query();
		$array = array();

		/*rank results by matching fields and a ranking system*/
		$total = count($cols_backup); //each field is worth 1 point right now

		while(($row=$dataReader->read())!==false) {

			$rank = 0;
			if($total > 0){

				foreach($cols_backup AS $key => $value){
					//echo "ROW: ".$row[$col] . "\n";
					//echo "COL: ".$key . "\n";
					//echo "VAL: ".$value . "\n\n";
					
					if(	$key == "status_id" || 
						$key == "country_id" || 
						$key == "city_id" || 
						$key == "available" ){

						if($row[$key] == $value){
							$rank++;
						}
					} else {
						if($row[$key] > 0){
							$rank++;
						}
					}
				}

				$rank = round($rank / $total * 100, PHP_ROUND_HALF_UP);
			}

			//$array[$row['id']] = array( $rank => $row );
			$array[$row['id']] = $row;
			$array[$row['id']]['rank'] = $rank;

			$rank_array[$row['id']] = $rank;
		}
		
		//Sort by relevance
		array_multisort($rank_array, SORT_DESC, $array);

		//Pagination
		$array = array_slice($array, ($filter['page'] - 1) * $filter['per_page'], $filter['per_page']);
		
		//DEBUG
		/*echo $type."\n";
		echo "# of conditions: $total\n";
		print_r($cols_backup);
		echo $sql;
		print_r($array);*/

		//Load the array with data!
		if($type == "idea") {
			return $this->idea("search", $filter, $array);
		} elseif($type == "user") {
			return $this->user("search", $filter, $array);
		}
	}
}