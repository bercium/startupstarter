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

		$language = Language::Model()->findByAttributes( array( 'language_code' => Yii::app()->language ) );
		$filter['site_lang'] = $language->id;

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
		$this->level = 0;

	//UNSET VARIABLES
		unset($filter['regflow']);

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
		   		$search = new SearchBuilder;
		    	$search = $search->search("idea", $filter);
		    	if(count($search) > 0) return $this->idea("search", $filter, $search);
		    	else return false;
		        break;
		    case "search_idea_count":
		    	$filter['idea_count'] = true;
		    	$search = new SearchBuilder;
		        return $search->search("idea", $filter);
		        break;
		    //user related data
		    case "user":
		    	if(isset($filter['user_id'])){
		    		//print_r($this->user("user", $filter));
		        	return $this->user("user", $filter);
		        }
		        break;
		    case "regflow":
		    	if(isset($filter['user_id'])){
			    	$filter['regflow'] = true;
			    	return $this->user("user", $filter);
			    }
		    case "search_user":
		    	$search = new SearchBuilder;
		    	$search = $search->search("user", $filter);
		    	if(count($search) > 0) return $this->user("search", $filter, $search);
		    	else return false;
		        break;
		    case "search_user_count":
		    	$filter['user_count'] = true;
		    	$search = new SearchBuilder;
		    	return $search->search("user", $filter);
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

		$this->level++;

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
					"AND t.language_id = {$filter['site_lang']} ".

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
					"AND t.language_id = {$filter['site_lang']} ".

					"WHERE i.deleted = 0 ".					
					"ORDER BY im.type_id ASC, i.time_registered DESC";

		} elseif( $type == 'idea' ){
			$sql=	"SELECT i.*, ist.name AS status, t.translation AS status_translation FROM ".
					"`idea` AS i ".

					"LEFT JOIN `idea_status` AS ist	".
					"ON i.status_id = ist.id ".

					"LEFT JOIN `translation` AS t ".
					"ON ist.id = t.row_id ".
					"AND t.table = 'idea_status' ".
					"AND t.language_id = {$filter['site_lang']} ".

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
					"AND t.language_id = {$filter['site_lang']} ".

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

				$row['date_updated'] = Yii::app()->dateFormatter->formatDateTime(strtotime($row['time_updated']));
				$row['days_updated'] = floor( (time() - strtotime($row['time_updated'])) / 86400 );
				$row['translation_other'] = $this->idea_translation( 'other', $filter );
				if($type != 'user'){
					$row['candidate'] = $this->user( 'candidate', $filter );
					$row['member'] = $this->user( 'member', $filter );
					$row['num_of_members'] = count($row['member']);
				}
				//add link
				$row['link'] = $this->link( 'idea', $filter );
				$row['gallery'] = $this->gallery( $filter );

				if($type == 'user' && $this->level < 3){
					$row['member'] = $this->user( 'member', $filter );
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

		$this->level--;

		return $array;
	}

	public function idea_translation($type, $filter){

		if($type == 'userlang'){
			$sql=		"SELECT it.id AS translation_id, it.title, it.keywords, it.pitch, it.description, it.description_public, it.tweetpitch, it.language_id, l.native_name AS language, l.language_code FROM ".
						"`idea` AS i,`idea_translation` AS it,`language` AS l ".
						"WHERE i.id = it.idea_id ".
						"AND l.id = it.language_id ".
						"AND it.deleted = 0 ".
						"AND it.idea_id = {$filter['idea_id']} ".
						"ORDER BY FIELD(it.language_id, '{$filter['lang']}') DESC LIMIT 1";

		} else {
			$sql=		"SELECT it.id AS translation_id, it.title, it.keywords, it.pitch, it.description, it.description_public, it.tweetpitch, it.language_id, l.native_name AS language, l.language_code FROM ".
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

		$this->level++;

		if( $type == 'user' ) {
			//return specific user's data
			$sql=	"SELECT m.id AS match_id, ".
					"u.id AS id, u.email, u.create_at, u.lastvisit_at, u.superuser, u.status, ".
					"u.name, u.surname, u.address, u.avatar_link, u.language_id, u.newsletter, u.bio, ".
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
					"AND t.language_id = {$filter['site_lang']} ".
					"WHERE m.user_id > 0 AND u.id = '{$filter['user_id']}'";

			if(isset($filter['regflow'])){
				$sql.= " AND u.status = 0";
			} else {
				$sql.= " AND u.status = 1";
			}
			

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
					"AND t.language_id = {$filter['site_lang']} ".

					"WHERE m.user_id > 0 AND u.status = 1 ".
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
					"AND t.language_id = {$filter['site_lang']} ".

					"WHERE m.user_id > 0 AND u.status = 1 ".
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
					"AND t.language_id = {$filter['site_lang']} ".

					"WHERE m.user_id IS NULL ".
					"AND im.idea_id = '{$filter['idea_id']}' ".
					"AND im.type_id = '3' ". //HARDCODED CANDIDATE
					"ORDER BY m.id DESC";

		} elseif($type == 'count_user'){
			//for pagination
			$sql=	"SELECT count(u.id) AS count FROM ".
					"`user` AS u 
           INNER JOIN `user_match` AS m ON u.id = m.user_id
           WHERE m.user_id > 0  AND u.status = 1";
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
					"AND t.language_id = {$filter['site_lang']} ".

					"WHERE m.user_id > 0  AND u.status = 1 ".
					"AND ( ";

			$keys = array();
			foreach( $data AS $key => $value ){
				$condition[] =	"m.id = {$value['id']}";
				$keys[] = $value['id'];
			}
			$sql.= implode($condition, " OR ") . " ) ORDER BY FIELD(m.id, ".implode($keys, ', ').") ASC ";
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
				if($this->level <= 2){
					$row['idea'] = $this->idea('user', $filter);
					$i = 0;
					if(count($row['idea']) > 0){
						foreach($row['idea'] AS $key => $value)
							$i++;
					}
					$row['num_of_rows'] = $i;
				}

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
					$row['link'] = $this->link( 'user', $filter );
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

		$this->level--;

		return $array;
	}

	public function collabpref($type, $filter){

		if($type == 'combined'){
			$sql=	"SELECT uc.id, collabpref.id AS collab_id, collabpref.name, t.translation, uc.id AS active FROM collabpref LEFT JOIN ".
					"(SELECT * FROM user_collabpref WHERE match_id = {$filter['match_id']}) AS uc ON uc.collab_id = collabpref.id ".
					"LEFT JOIN translation AS t ".
					"ON collabpref.id = t.row_id ".
					"AND t.table = 'collabpref' ".
					"AND t.language_id = '{$filter['site_lang']}'";
		} elseif($type == 'empty'){
			$sql=	"SELECT collabpref.id AS collab_id, collabpref.name, t.translation, 0 AS active FROM collabpref ".
					"LEFT JOIN translation AS t ".
					"ON collabpref.id = t.row_id ".
					"AND t.table = 'collabpref' ".
					"AND t.language_id = '{$filter['site_lang']}'";
		} else {
			$sql=	"SELECT uc.id, c.id AS collab_id, c.name, t.translation FROM ".
					"`collabpref` AS c ".
					"LEFT JOIN `user_collabpref` AS uc ".
					"ON uc.collab_id = c.id ".
					"LEFT JOIN translation AS t ".
					"ON c.id = t.row_id ".
					"AND t.table = 'collabpref'".
					"AND t.language_id = '{$filter['site_lang']}'".
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

		$sql=		"SELECT ss.id, ss.name AS skillset, t.translation FROM ".
					"`user_skill` AS us ".
					"LEFT JOIN `skillset` AS ss ".
					"ON ss.id = us.skillset_id ".
					"LEFT JOIN translation AS t ".
					"ON ss.id = t.row_id ".
					"AND t.table = 'skillset'".
					"AND language_id = '{$filter['site_lang']}'".
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

			$array[$row['id']] = $row;
			$array[$row['id']]['skill'] = $this->skillset_skill( $filter );
		}

		return $array;
	}

	public function skillset_skill($filter){

		$sql=		"SELECT s.id, s.name AS skill FROM ".
					"`user_skill` AS us ".
					"LEFT JOIN `skill` AS s ".
					"ON s.id = us.skill_id ".
					"WHERE us.skillset_id = '{$filter['skillset_id']}' ".
					"AND us.match_id = '{$filter['match_id']}' ".
					"GROUP BY s.id";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$array = array();

		while(($row=$dataReader->read())!==false) {
			$array[$row['id']] = $row;
		}
		return $array;
	}

	public function link($type, $filter){

		if($type == 'user'){
			$sql=		"SELECT ul.* FROM ".
						"`user_link` AS ul ".
						"WHERE ul.user_id = '{$filter['uid']}'";
		} elseif($type == 'idea'){
			$sql=		"SELECT il.* FROM ".
						"`idea_link` AS il ".
						"WHERE il.idea_id = '{$filter['idea_id']}'";
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

	public function gallery($filter){

		$sql=		"SELECT ig.* FROM ".
					"`idea_gallery` AS ig ".
					"WHERE ig.idea_id = '{$filter['idea_id']}'";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$array = array();

		while(($row=$dataReader->read())!==false) {
			$array[$row['id']] = $row;
		}

		return $array;
	}

}
