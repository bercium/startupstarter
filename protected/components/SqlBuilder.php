<?php
/*
TODO:
-search
		language_id (search)
			idea_translation ---($k rows) -> $filter['language_id'][N] = $id;
		country_id (MULTIPLE ENTRIES)
		city_id (MULTIPLE ENTRIES)
*/

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
		    //search
		    //idea related data
		    case "idea":
		    	if(isset($filter['idea_id'])){
		        	return $this->idea("idea", $filter);
		        }
		        break;
		    case "search_idea":
		        return $this->search("idea", $filter);
		        break;
		    //user related data
		    case "user":
		    	if(isset($filter['user_id'])){
		        	return $this->user("user", $filter);
		        }
		        break;
		    case "search_user":
		    	return $this->search("user", $filter);
		        break;
		    //pagination data
		    case "count_idea":
		    	return $this->idea("count_idea", $filter);
		        break;
		    case "count_user":
		    	return $this->user("count_user", $filter);
		        break;
		    //collabpref
		    case "collabpref":
		    	return $this->collabpref("combined", $filter);
		        break;
		    case "collabpref_empty":
		    	return $this->collabpref("empty", $filter);
		        break;
		}

	}

	public function idea($type, $filter, $data = array()){

		if( $type == 'recent_candidate'){
			//currently not in use
			/*$sql =	"SELECT i.*, ist.name AS status FROM ".
					"`idea` AS i, `idea_status` AS ist, `idea_member` AS im, `user_match` AS m ".
					"WHERE i.id = im.idea_id ".
					"AND i.status_id = ist.id ".
					"AND i.deleted = 0 ".
					"AND im.match_id = m.id ".
					"AND m.user_id IS NULL ".
					"AND it.deleted = 0 ".
					"ORDER BY m.id DESC ".
					"LIMIT ". ($filter['page'] - 1) * $filter['per_page'] .", ". ($filter['per_page']);*/

		} elseif( $type == 'recent_updated' ) {
			$sql =	"SELECT i.*, ist.name AS status, t.translation AS status_translation FROM ".
					"`idea` AS i ".

					"LEFT JOIN `idea_status` AS ist ".
					"ON ist.id = i.status_id ".

					"LEFT JOIN `translation` AS t ".
					"ON ist.id = t.row_id ".
					"AND t.table = 'idea_status' ".
					"AND t.language_id = {$filter['lang']} ".

					"WHERE i.deleted = 0 ".
					"ORDER BY i.time_updated DESC ".
					"LIMIT ". ($filter['page'] - 1) * $filter['per_page'] .", ". ($filter['per_page']);

		} elseif( $type == 'user' ) {
			$sql=	"SELECT i.*, ist.name AS status, t.translation AS status_translation, im.type_id FROM ".
					"`idea` AS i ".

					"INNER JOIN `idea_member` AS im ".
					"ON i.id = im.idea_id ".
					"AND im.match_id = '{$filter['match_id']}' ".

					"LEFT JOIN `idea_status` AS ist	".
					"ON i.status_id = ist.id ".

					"LEFT JOIN `translation` AS t ".
					"ON ist.id = t.row_id ".
					"AND t.table = 'idea_status' ".
					"AND t.language_id = {$filter['lang']} ".

					"WHERE i.deleted = 0 ".					
					"ORDER BY i.time_registered DESC";

		} elseif( $type == 'idea' ){
			$sql=	"SELECT i.*, ist.name AS status, t.translation AS status_translation FROM ".
					"`idea` AS i ".

					"LEFT JOIN `idea_status` AS ist	".
					"ON i.status_id = ist.id ".

					"LEFT JOIN `translation` AS t ".
					"ON ist.id = t.row_id ".
					"AND t.table = 'idea_status' ".
					"AND t.language_id = {$filter['lang']} ".

					"WHERE i.id = '{$filter['idea_id']}' ".
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
					"GROUP BY ci.idea_click_id";

		} elseif( $type == 'search' ){
			$sql =	"SELECT i.*, ist.name AS status, t.translation AS status_translation FROM ".
					"`idea` AS i ".

					"LEFT JOIN `idea_status` AS ist	".
					"ON i.status_id = ist.id ".

					"LEFT JOIN `translation` AS t ".
					"ON ist.id = t.row_id ".
					"AND t.table = 'idea_status' ".
					"AND t.language_id = {$filter['lang']} ".

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
				$merge = $this->idea_translation( 'userlang', $filter );
				if(isset($merge['language_id'])){
					$row = array_merge($row, $merge);
					$filter['default_lang'] = $merge['language_id'];
				} else {
					$filter['default_lang'] = $filter['lang'];
				}
				if(strlen($row['status_translation']) > 0){
					$row['status'] = $row['status_translation'];
				}
				unset($row['status_translation']);

				if($type != 'user'){
					$row['translation_other'] = $this->idea_translation( 'other', $filter );
					$row['member'] = $this->user( 'member', $filter );
					$row['num_of_members'] = count($row['member']);
					$row['candidate'] = $this->user( 'candidate', $filter );
					$row['date_updated'] = Yii::app()->dateFormatter->formatDateTime(strtotime($row['time_updated']));
					$row['days_updated'] = round( (strtotime($row['time_updated']) - time()) / 86400 , 0, PHP_ROUND_HALF_DOWN ) * -1;	
				}

				//add number of clicks
				if($filter['action'] == ('user' || 'idea')){
					$num_of_clicks = $this->idea('count_clicks', $filter);
					if(!is_array($num_of_clicks) AND is_numeric($num_of_clicks)){
						$row['num_of_clicks'] = $num_of_clicks;
					} else {
						$row['num_of_clicks'] = 0;
					}
						
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

	public function idea_translation($type, $filter){

		if($type == 'userlang'){
			$sql=		"SELECT it.id AS translation_id, it.title, it.keywords, it.pitch, it.description, it.description_public, it.tweetpitch, it.language_id, l.name AS language, l.language_code FROM ".
						"`idea` AS i,`idea_translation` AS it,`language` AS l ".
						"WHERE i.id = it.idea_id ".
						"AND l.id = it.language_id ".
						"AND it.deleted = 0 ".
						"AND it.idea_id = {$filter['idea_id']} ".
						"ORDER BY FIELD(it.language_id, '{$filter['lang']}') DESC LIMIT 1";

		} else {
			$sql=		"SELECT it.id AS translation_id, it.title, it.keywords, it.pitch, it.description, it.description_public, it.tweetpitch, it.language_id, l.name AS language, l.language_code FROM ".
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
				$array[$row['translation_id']] = $row;
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
					"m.available, a.name AS available_name, t.translation AS available_translation FROM ".
					"`user_match` AS m ".
			
					"INNER JOIN `user` AS u ON m.user_id = u.id ".
					"LEFT JOIN `country` AS c ON c.id = m.country_id ".
					"LEFT JOIN `city` AS ci ON ci.id = m.city_id ".
					"LEFT JOIN `language` AS l ON u.language_id = l.id ".

					"LEFT JOIN `available` AS a ON a.id = m.available ".
					"LEFT JOIN `translation` AS t ".
					"ON a.id = t.row_id ".
					"AND t.table = 'available' ".
					"AND t.language_id = {$filter['lang']} ".

					"WHERE m.user_id > 0 AND u.id = '{$filter['user_id']}'";

		} elseif( $type == 'recent' ){
			//return recently registered users' data
			$sql=	"SELECT m.id AS match_id, ".
					"u.id AS id, u.email, u.create_at, u.lastvisit_at, u.superuser, u.status, ".
					"u.name, u.surname, u.address, u.avatar_link, u.language_id, u.newsletter, ".
					"l.name AS language, c.name AS country, ci.name AS city, m.country_id, m.city_id, ".
					"m.available, a.name AS available_name, t.translation AS available_translation FROM ".
					"`user_match` AS m ".

					"INNER JOIN `user` AS u ON m.user_id = u.id ".
					"LEFT JOIN `country` AS c ON c.id = m.country_id ".
					"LEFT JOIN `city` AS ci ON ci.id = m.city_id ".
					"LEFT JOIN `language` AS l ON u.language_id = l.id ".

					"LEFT JOIN `available` AS a ON a.id = m.available ".
					"LEFT JOIN `translation` AS t ".
					"ON a.id = t.row_id ".
					"AND t.table = 'available' ".
					"AND t.language_id = {$filter['lang']} ".

					"WHERE m.user_id > 0 ".
					"ORDER BY u.create_at DESC ".
					"LIMIT ". ($filter['page'] - 1) * $filter['per_page'] .", ". $filter['per_page'];

		} elseif( $type == 'member' ) {
			//return members of an idea
			$sql=	"SELECT m.id AS match_id, im.type_id, mt.name AS type, ".
					"u.id AS id, u.email, u.create_at, u.lastvisit_at, u.superuser, u.status, ".
					"u.name, u.surname, u.address, u.avatar_link, u.language_id, u.newsletter, ".
					"l.name AS language, c.name AS country, ci.name AS city, m.country_id, m.city_id, ".
					"m.available, a.name AS available_name, t.translation AS available_translation FROM ".
					"`idea_member` AS im ".

					"INNER JOIN `user_match` AS m ON im.match_id = m.id ".
					"LEFT JOIN `user` AS u ON m.user_id = u.id ".
					"LEFT JOIN `membertype` AS mt ON im.type_id = mt.id ".
					"LEFT JOIN `country` AS c ON c.id = m.country_id ".
					"LEFT JOIN `city` AS ci ON ci.id = m.city_id ".
					"LEFT JOIN `language` AS l ON u.language_id = l.id ".

					"LEFT JOIN `available` AS a ON a.id = m.available ".
					"LEFT JOIN `translation` AS t ".
					"ON a.id = t.row_id ".
					"AND t.table = 'available' ".
					"AND t.language_id = {$filter['lang']} ".

					"WHERE m.user_id > 0 ".
					"AND im.idea_id = '{$filter['idea_id']}' ".
					"AND (im.type_id = '2' || im.type_id = '1') ". //HARDCODED MEMBER TYPE
					"ORDER BY im.type_id ASC";

		} elseif( $type == 'candidate' ) {
			//return candidates of an idea
			$sql=	"SELECT m.id AS match_id, im.type_id, mt.name AS type, ".
					"c.name AS country, ci.name AS city, m.country_id, m.city_id, ".
					"m.available, a.name AS available_name, t.translation AS available_translation FROM ".
					"`idea_member` AS im ".

					"INNER JOIN `user_match` AS m ON im.match_id = m.id ".
					"LEFT JOIN `membertype` AS mt ON im.type_id = mt.id ".
					"LEFT JOIN `country` AS c ON c.id = m.country_id ".
					"LEFT JOIN `city` AS ci ON ci.id = m.city_id ".

					"LEFT JOIN `available` AS a ON a.id = m.available ".
					"LEFT JOIN `translation` AS t ".
					"ON a.id = t.row_id ".
					"AND t.table = 'available' ".
					"AND t.language_id = {$filter['lang']} ".

					"WHERE m.user_id IS NULL ".
					"AND im.idea_id = '{$filter['idea_id']}' ".
					"AND im.type_id = '3' ". //HARDCODED CANDIDATE
					"ORDER BY m.id DESC";

		} elseif($type == 'count_user'){
			//for pagination
			$sql=	"SELECT count(u.id) AS count FROM ".
					"`user` AS u 
           INNER JOIN `user_match` AS m ON u.id = m.user_id
           WHERE m.user_id > 0";
		} elseif( $type == 'search' ){

			$sql=	"SELECT m.id AS match_id, ".
					"u.id AS id, u.email, u.create_at, u.lastvisit_at, u.superuser, u.status, ".
					"u.name, u.surname, u.address, u.avatar_link, u.language_id, u.newsletter, ".
					"l.name AS language, c.name AS country, ci.name AS city, m.country_id, m.city_id, ".
					"m.available, a.name AS available_name, t.translation AS available_translation FROM ".
					"`user_match` AS m ".

					"INNER JOIN `user` AS u ON m.user_id = u.id ".
					"LEFT JOIN `country` AS c ON c.id = m.country_id ".
					"LEFT JOIN `city` AS ci ON ci.id = m.city_id ".
					"LEFT JOIN `language` AS l ON u.language_id = l.id ".

					"LEFT JOIN `available` AS a ON a.id = m.available ".
					"LEFT JOIN `translation` AS t ".
					"ON a.id = t.row_id ".
					"AND t.table = 'available' ".
					"AND t.language_id = {$filter['lang']} ".

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

				//translation
				if(strlen($row['available_translation']) > 0){
					$row['available_name'] = $row['available_translation'];
				}
				unset($row['available_translation']);
				
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
			$sql=	"SELECT uc.id, collabpref.id AS collab_id, collabpref.name, t.translation, uc.id AS active FROM collabpref LEFT JOIN ".
					"(SELECT * FROM user_collabpref WHERE match_id = {$filter['match_id']}) AS uc ON uc.collab_id = collabpref.id ".
					"LEFT JOIN translation AS t ".
					"ON collabpref.id = t.row_id ".
					"AND t.table = 'collabpref' ".
					"AND t.language_id = '{$filter['lang']}'";
		} elseif($type == 'empty'){
			$sql=	"SELECT collabpref.id AS collab_id, collabpref.name, t.translation, 0 AS active FROM collabpref ".
					"LEFT JOIN translation AS t ".
					"ON collabpref.id = t.row_id ".
					"AND t.table = 'collabpref' ".
					"AND t.language_id = '{$filter['lang']}'";
		} else {
			$sql=	"SELECT uc.id, c.id AS collab_id, c.name, t.translation FROM ".
					"`collabpref` AS c ".
					"LEFT JOIN `user_collabpref` AS uc ".
					"ON uc.collab_id = c.id ".
					"LEFT JOIN translation AS t ".
					"ON c.id = t.row_id ".
					"AND t.table = 'collabpref'".
					"AND t.language_id = '{$filter['lang']}'".
					"WHERE uc.match_id = '{$filter['match_id']}'";
		}

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$array = array();

		while(($row=$dataReader->read())!==false) {
			if(strlen($row['translation']) > 0){
				$row['name'] = $row['translation'];
			}
			$array[] = $row;
		}

		return $array;
	}

	public function skillset($filter){

		$sql=		"SELECT ss.id, ss.name AS skillset, t.translation, us.skill_id, sss.id AS skillset_skill_id FROM ".
					"`user_skill` AS us ".
					"LEFT JOIN `skillset` AS ss ".
					"ON ss.id = us.skillset_id ".
					"LEFT JOIN `skillset_skill` AS sss ".
					"ON sss.skillset_id = us.skillset_id ".
					"AND sss.skill_id = us.skill_id ".
					"LEFT JOIN translation AS t ".
					"ON ss.id = t.row_id ".
					"AND t.table = 'skillset'".
					"AND language_id = '{$filter['lang']}'".
					"WHERE us.match_id = '{$filter['match_id']}' ".
					"GROUP BY ss.id";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$array = array();

		while(($row=$dataReader->read())!==false) {

			if(strlen($row['translation']) > 0){
				$row['skillset'] = $row['translation'];
			}

			$filter['skillset_id'] = $row['id'];
			unset($filter['skill_id']);

			$array[$row['id']] = $row;

			if($row['skill_id'] > 0){
				$filter['skill_id'] = $row['skill_id'];
				unset($row['skill_id']);
				$array[$row['id']]['skill'] = $this->skillset_skill( $filter );
			}
		}

		return $array;
	}

	public function skillset_skill($filter){

		if(isset($filter['skill_id'])){

			$sql=		"SELECT s.id, s.name AS skill FROM ".
						"`user_skill` AS us ".
						"LEFT JOIN `skill` AS s ".
						"ON s.id = us.skill_id ".
						"WHERE s.id = '{$filter['skill_id']}' ".
						"AND us.skillset_id = '{$filter['skillset_id']}' ";
		}/* else {
			$sql=		"SELECT s.id, s.name AS skill FROM ".
						"`user_skill` AS us, ".
						"`skill` AS s ".
						"WHERE s.id = us.skill_id ".
						"AND us.skillset_id = '{$filter['skillset_id']}' ";
		}*/

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

		idea_keyword ---($k rows) -> $filter['keyword'];
			-keyword

		idea -> $filter['extra'];
			-website
			-video_link
		
		idea_status -> $filter['status'] = $value;
			-status_id

		user_match -> $filter['$key'] = '$value';
			Key
			-country_id
			-city_id
			-available

		user_collabpref ---($c rows) -> $filter['collabpref'][N] = '$value';

		user_skill  ---($ss rows) -> $filter['skill'][N]['$key'];
			-id
			-type = 1

		user_skill  ---($s rows) -> $filter['skill'][N]['$key'];
			-id = $value
			-type = 2*/

		//echo "\nFilter from input\n";
		//print_r($filter);

		/*Data preprocessing 1: breaking up keywords, finding matches, creating an array from IDs*/
		if( isset($filter['country']) ){
			if(is_numeric($filter['country'])){
				$filter['country'][] = $filter['country'];
			} else {
				$keyworder = new Keyworder;
				$country = $keyworder->string2array($filter['country']);
				unset($filter['country']);

				//!!!debug
				//print_r($country);

				foreach($country AS $key => $value){
					if(strlen($value) >= 3){
						$value = addcslashes($value, '%_'); // escape LIKE's special characters	
						$condition = new CDbCriteria( array(
						    'condition' => "name LIKE :name",         // no quotes around :match
						    'params'    => array(':name' => "%$value%")  // Aha! Wildcards go here
						) );

						$dataReader = Country::Model()->findAll( $condition );

						

						foreach ($dataReader as $row){
							$filter['country'][] = $row['id'];
						}
					}
				}
			}
		}
		if( isset($filter['city']) ){
			if(is_numeric($filter['city'])){
				$filter['city'][] = $filter['city'];
			} else {
				$keyworder = new Keyworder;
				$city = $keyworder->string2array($filter['city']);
				unset($filter['city']);

				//!!!debug
				//print_r($city);

				foreach($city AS $key => $value){
					if(strlen($value) >= 3){
						$value = addcslashes($value, '%_'); // escape LIKE's special characters
						$condition = new CDbCriteria( array(
						    'condition' => "name LIKE :name",         // no quotes around :match
						    'params'    => array(':name' => "%$value%")  // Aha! Wildcards go here
						) );
						$dataReader = City::Model()->findAll( $condition );

						unset($filter['city']);

						foreach ($dataReader as $row){
							$filter['city'][] = $row['id'];
						}
					}
				}
			}
		}
		if( isset($filter['skill']) && is_array($filter['skill']) && count($filter['skill']) > 0  ){
			foreach($filter['skill'] AS $key => $value){
				if($value['type'] == '1')
					$filter['skillset'][] = $value['id']; //skillset_id
				if($value['type'] == '2')
					$filter['skillset_skill'][] = $value['id']; //skillset_skill's id
			}
		} else {
			if(isset($filter['skill']) && strlen($filter['skill']) > 0){

				//break up into keywords
				$keyworder = new Keyworder;
				$skills = $keyworder->string2array($filter['skill']);

				//print_r($skills);

				foreach($skills AS $key => $value){

					//this is deficient... why?
					/*
						-languages are not checked yet FIRST ISSUE TO BE SOLVED

						-skillset_skill has been omitted (from here and from all the following sql sentences)
						-skillset needs to be checked through translation and skillset tables
						-these together add up into relevancy and efficiency issues
						//recheck when we're optimizing experience and performance
						//!!!efficiency
						//!!!UX

						undersigned Blaž
					*/
					if(strlen($value) >= 3){
						$criteria=new CDbCriteria();
						
						// translated skill sets
						//!!!language
						if($filter['lang'] != 40){
							$value = addcslashes($value, '%_'); // escape LIKE's special characters
							$criteria->condition = " `translation` LIKE :name AND `table` = 'skillset'"; //AND language_id = 
							$criteria->params = array(":name"=>"%".$value."%");
							$dataReader = Translation::model()->findAll($criteria);

							//$data = array();
							foreach ($dataReader as $row){
								$filter['skillset'][] = $row['row_id'];
							}
						}
						
						$criteria->condition = " `name` LIKE :name";
						$criteria->params = array(":name"=>"%".$value."%");
						
						// original skill sets
						$dataReader = Skillset::model()->findAll($criteria);

						//$data = array();
						foreach ($dataReader as $row){
							$filter['skillset'][] = $row['id'];
						}

						// skills
						$dataReader = Skill::model()->findAll($criteria);
						
						foreach ($dataReader as $row){
							$filter['skillset_skill'][] = $row['id'];
						}
					}
				}
			}
		}
		if( isset($filter['keywords']) && strlen($filter['keywords']) > 0){
			$keyworder = new Keyworder;
			$keywords = $keyworder->string2array($filter['keywords']);

			foreach($keywords AS $key => $value){
				if(strlen($value) >= 3){
					$value = addcslashes($value, '%_'); // escape LIKE's special characters
					$condition = new CDbCriteria( array(
					    'condition' => "`keyword` LIKE :value AND `table` = 'idea_translation'",         // no quotes around :match
					    'params'    => array(':value' => "%".$value."%")  // Aha! Wildcards go here
					) );

					$dataReader = Keyword::Model()->findAll( $condition );

					foreach($dataReader AS $row){
						$filter['keyword'][] = $row['id'];
					}
				}
			}
		}
		if( isset($filter['stage']) && is_numeric($filter['stage']) ){
			$filter['status_id'] = $filter['stage'];
		}

		//!!!debug
		/*if(isset($filter['skillset'])){
			echo "Skillset";
			print_r($filter['skillset']);
		}
		if(isset($filter['skillset_skill'])){
			echo "Skillset_skill";
			print_r($filter['skillset_skill']);
		}*/
		//echo "\nFilter after processing input\n";
		//print_r($filter);
		//	die();

		/*SQL query processing (idea data, grouped by candidates)*/
		
		if($type == "idea"){
			$sql = "SELECT i.id AS id, ";
		} elseif($type == "user") {
			$sql = "SELECT m.id AS id, ";
		}

		/*FIELDS TO PULL*/
		//only for idea
		if($type == "idea"){
			//keyword AS k
			if( isset($filter['keyword']) && is_array($filter['keyword']) && count($filter['keyword']) > 0 ){
				$k = -1;
				foreach($filter['keyword'] AS $key => $value){
					$k++;
					$sql.= "k{$k}.id AS k{$k}_id, ";
				}
			}

			//idea AS i
			if(isset($filter['status_id']) AND is_numeric($filter['status_id'])){
				$sql.=	"i.status_id, ";
			}
			if(isset($filter['extra']) && $filter['extra'] == 1){
				$sql.=	"i.website, 
						i.video_link, ";
			}
		}

		//applies to everything
		//country as co
		//print_r($filter['country_id	']);
		if( isset($filter['country']) && is_array($filter['country']) && count($filter['country']) > 0 ){
			$co = -1;
			foreach($filter['country'] AS $key => $value){
				//echo $co."\n";
				if(is_numeric($value)){
					$co++;
					$sql.= "co{$co}.id AS co{$co}_id, ";
					//echo $co."\n";
					//echo "\n";
				}

			}
		}
		//city as ci

		if( isset($filter['city']) && is_array($filter['city']) && count($filter['city']) > 0 ){
			$ci = -1;
			foreach($filter['city'] AS $key => $value){
				if(is_numeric($value)){
					$ci++;
					$sql.= "ci{$ci}.id AS ci{$ci}_id, ";
				}
			}
		}

		//user_match AS m
		if(isset($filter['available']) AND is_numeric($filter['available'])){
			$sql.=	"m.available, ";
		}

		//idea_translation AS it
		if(isset($filter['language']) AND is_numeric($filter['language'])){
			$sql.=	"it.language_id, ";
		}

		//user_collabpref AS c
		if( isset($filter['collabpref']) && is_array($filter['collabpref']) && count($filter['collabpref']) > 0 ){
			$c = -1;
			foreach($filter['collabpref'] AS $key => $value){
				if(is_numeric($value)){
					$c++;
					$sql.= "c{$c}.id AS c{$c}_id, ";
				}
			}
		}

		//user_skill (skillset) AS ms
		if( isset($filter['skillset']) && is_array($filter['skillset']) && count($filter['skillset']) > 0 ){
			$ms = -1;
			foreach($filter['skillset'] AS $key => $value){
				if(is_numeric($value)){
					$ms++;
					$sql.= "ms{$ms}.id AS ms{$ms}_id, ";
				}
			}
		}
		//user_skill (skillset_skill) AS mss
		if( isset($filter['skillset_skill']) && is_array($filter['skillset_skill']) && count($filter['skillset_skill']) > 0 ){
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
			if( isset($filter['keywords']) && is_array($filter['keyword']) && count($filter['keyword']) > 0 ){
				$k = -1;
				foreach($filter['keyword'] AS $key => $value){
					//$VALUE INPUT VALIDATION NEEDED
					$k++;
					$sql.= "LEFT JOIN `keyword` AS k{$k} ON 
								k{$k}.table = 'idea_translation' 
								AND k{$k}.row_id = i.id 
								AND k{$k}.id = :k{$k}_id ";
					$cols["k{$k}_id"] = $value; //this key is an _id here, but it's really a string
				}
			}

			//idea AS i
			//the following field does not require joins, we're merely preparing variables for result ranking
			if(isset($filter['status_id']) AND is_numeric($filter['status_id'])){
				$cols["status_id"] = $filter['status_id'];
			}
			if(isset($filter['extra']) && $filter['extra'] == 1){
				$cols["website"] = "";
				$cols["video_link"] = "";
			}
		}

		//user_match AS m
		//the following fields do not require joins, we're merely preparing variables for result ranking
		
		/*if(isset($filter['country_id']) AND is_numeric($filter['country_id'])){
			$cols["country_id"] = $filter['country_id'];
		}
		if(isset($filter['city_id']) AND is_numeric($filter['city_id'])){
			$cols["city_id"] = $filter['city_id'];
		}*/
		if(isset($filter['available']) AND is_numeric($filter['available'])){
			$cols["available"] = $filter['available'];
		}

		//language
		if(isset($filter['language']) AND is_numeric($filter['language'])){
			$sql.= "LEFT JOIN `idea_translation` AS it ON 
						it.idea_id = i.id ";
			$cols["language_id"] = $filter['language'];
		}

		//user_match (country) as co
		if( isset($filter['country']) && is_array($filter['country']) && count($filter['country']) > 0 ){
			$co = -1;
			foreach($filter['country'] AS $key => $value){
				if(is_numeric($value)){
					$co++;
					$sql.= "LEFT JOIN `country` AS co{$co} ON 
								co{$co}.id = m.country_id  
								AND co{$co}.id = :co{$co}_id ";
					$cols["co{$co}_id"] = $value;
				}
			}
		}
		//user_match (city) as ci
		if( isset($filter['city']) && is_array($filter['city']) && count($filter['city']) > 0 ){
			$ci = -1;
			foreach($filter['city'] AS $key => $value){
				if(is_numeric($value)){
					$ci++;
					$sql.= "LEFT JOIN `city` AS ci{$ci} ON 
								ci{$ci}.id = m.city_id  
								AND ci{$ci}.id = :ci{$ci}_id ";
					$cols["ci{$ci}_id"] = $value;
				}
			}
		}

		//user_collabpref AS c
		if( isset($filter['collabpref']) && is_array($filter['collabpref']) && count($filter['collabpref']) > 0 ){
			$c = -1;
			foreach($filter['collabpref'] AS $key => $value){
				if(is_numeric($value)){
					$c++;
					$sql.= "LEFT JOIN `user_collabpref` AS c{$c} ON 
								c{$c}.match_id = m.id  
								AND c{$c}.id = :c{$c}_id ";
					$cols["c{$c}_id"] = $value;
				}
			}
		}

		//user_skill (skillset) AS ms
		if( isset($filter['skillset']) && is_array($filter['skillset']) && count($filter['skillset']) > 0 ){
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
		//has been downscaled
		if( isset($filter['skillset_skill']) && is_array($filter['skillset_skill']) && count($filter['skillset_skill']) > 0 ){
			$mss = -1;
			foreach($filter['skillset_skill'] AS $key => $value){
				if(is_numeric($value)){
					$mss++;
					$sql.= "LEFT JOIN `user_skill` AS mss{$mss} ON 
								mss{$mss}.match_id = m.id 
								AND mss{$mss}.skill_id = :mss{$mss}_id ";
					$cols["mss{$mss}_id"] = $value;
				}
			}
		}

		if($type == "idea") {
			//group by idea_id
			//because it's highly relevant if one person has skills sought in several candidates
			$sql.=	" WHERE i.deleted = 0 GROUP BY i.id";
		} elseif($type == "user") {
			$sql.=	" WHERE m.user_id > 0 
					 GROUP BY m.id";
		}

		/*print_r($cols);
		echo $sql;
		die();*/
		/*WE GOT SQL SENTENCE BUILT ($sql), DATA GATHERED ($cols) LETS RUN THIS STUFF*/
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);

		/*BIND COLUMNS TO SQL*/
		$cols_backup = $cols;
		//print_r($cols);
		foreach($cols as $col =>  &$value){ // $value can be changed by the body of foreach loop.
			if($col != 'status_id' && $col != 'available' && $col != 'language_id' && $col != 'website' && $col != 'video_link')
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
					/*echo "ROW: ".$row[$col] . "\n";
					echo "COL: ".$key . "\n";
					echo "VAL: ".$value . "\n\n";*/
					
					if(	$key == "status_id" || 
						$key == "available" ||
						$key == "language_id" ){

						if($row[$key] == $value){
							$rank++;
						}
					} elseif( $key == "website" || 
						$key == "video_link" ){

						//!!!isurl regex
						if(strlen($value) > 3){
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

/*
FILTERS:
a) page //default(1)
b) per_page //default(3 = ajax, 12 = noajax)
c) lang (alias: language_id) //default(user's settings)
d) user_id
e) idea_id
f) skillset_mode
(no default means that the variable is mandatory)

INSIDE FILTERS:
g) default_lang (alias: language_id) //from user.userlang
h) match_id
i) uid (alias: user_id) //to avoid conflicts with user_id

		idea_keyword ---($k rows) -> $filter['keyword'];
			-keyword

		idea -> $filter['extra'];
			-website
			-video_link
		
		idea_status -> $filter['status'] = $value;
			-status_id

		idea_status -> $filter['language'] = $value;
			-status_id

		user_match -> $filter['$key'] = '$value';
			Key
			-country_id
			-city_id
			-available

		user_collabpref ---($c rows) -> $filter['collabpref'][N] = '$value';

		user_skill  ---($ss rows) -> $filter['skill'][N]['$key'];
			-id
			-type = 1

		user_skill  ---($s rows) -> $filter['skill'][N]['$key'];
			-id = $value
			-type = 2*/

//pagination.
//*/
