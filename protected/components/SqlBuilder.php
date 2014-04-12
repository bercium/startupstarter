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
	public function load_array($action, $filter = Array(), $structure = ""){

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

	//STRUCTURE
		if($structure == ""){
			if($action == "recent_users" || $action == "search_users" || $action == "user" || $action == "regflow"){
				$structure = "collabpref,link,skill,industry,num_of_ideas,idea,member,gallery,translation";
			} elseif($action == "recent_ideas" || $action == "search_ideas" || $action == "idea" ){
				$structure = "translation,translation_other,link,member,gallery,candidate,skill,industry,collabpref";
			}
		}

	//UNSET VARIABLES
		unset($filter['regflow']);

	//WHICH ACTION IS PERFORMED?
		switch ($action) {

			//frontpage controller
		    case "recent_ideas":
		    	return $this->idea("recent_updated", $filter, array(), $structure);
		        break;

		    case "recent_users":
		        return $this->user("recent", $filter, array(), $structure);
		        break;

		    //search
		    case "search_ideas":
		   		$search = new SearchBuilder2;

		   		if(isset($filter['where'])){
		   			$search = $search->search("idea", $filter, $filter['where']);
		   		} else {
		   			$search = $search->search("idea", $filter);
		   		}

		    	$search['results'] = $this->idea("search", $filter, $search['results'], $structure);
		    	return $search;
		        break;

		    case "search_users":
		    	$search = new SearchBuilder2;
		    	
		    	if(isset($filter['where'])){
		    		$search = $search->search("user", $filter, $filter['where']);
		    	} else {
		    		$search = $search->search("user", $filter);
		    	}
		    	
		    	$search['results'] = $this->user("search", $filter, $search['results'], $structure);
		    	return $search;
		        break;

		    //idea
		    case "idea":
		    	if(isset($filter['idea_id'])){
		        	return $this->idea("idea", $filter, array(), $structure);
		        }
		        break;

		    //user
		    case "user":
		    	if(isset($filter['user_id'])){
		        	return $this->user("user", $filter, array(), $structure);
		        }
		        break;

		    case "regflow":
		    	if(isset($filter['user_id'])){
			    	$filter['regflow'] = true;
			    	return $this->user("user", $filter, array(), $structure);
			    }

		    //collabpref
		    case "collabpref":
		    	return $this->collabpref("combined", $filter);
		        break;
		    case "collabpref_empty":
		    	return $this->collabpref("empty", $filter);
		        break;

		    //pagination data
		    case "count_ideas":
		    	return $this->count("ideas", $filter);
		        break;

		    case "count_users":
		    	return $this->count("users", $filter);
		        break;

		}

	}

	public function user($type, $filter = 0, $data = array(), $structure = ""){

		if( $type == 'user' ) {
			//return specific user's data
			$sql=	"SELECT m.id AS match_id, ".
					"u.id AS id, u.email, u.create_at, u.lastvisit_at, u.superuser, u.status, ".
					"u.name, u.surname, u.address, u.avatar_link, u.language_id, u.newsletter, u.bio, u.personal_achievement, ".
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
        if (!Yii::app()->user->isAdmin()) $sql.= " AND u.status = 1";
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
                  
			        "LEFT JOIN `user_stat` AS us ".
			        "ON u.id = us.user_id ".

					"WHERE m.user_id > 0 AND u.status = 1 AND us.completeness >= ".PROFILE_COMPLETENESS_MIN." ";

					//set exclude users where query
					if(isset($filter['exclude'])){
						$sql.= " AND u.id != " . implode($filter['exclude'], " AND u.id != ")." ";
					}

			$sql.= 	"ORDER BY u.create_at DESC ".
					"LIMIT ". ($filter['page'] - 1) * $filter['per_page'] .", ". $filter['per_page'];

					//echo $sql;

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
			$condition = array();
			foreach( $data AS $key => $value ){
				$condition[] =	"m.id = {$value['id']}";
				$keys[] = $value['id'];
			}
			if(count($condition) == 0) return false;
			$sql.= implode($condition, " OR ") . " ) ORDER BY FIELD(m.id, ".implode($keys, ', ').") ASC ";
		}

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$array = array();

		while(($row=$dataReader->read())!==false) {
			
			//set filter
			$filter['match_id'] = $row['match_id'];

			//available & translation
			if(strlen($row['available_translation']) > 0){
				$row['available_name'] = $row['available_translation'];
			}
			unset($row['available_translation']);

			//collabpref data
			if(strpos($structure, 'collabpref') !== false){
				if($type == 'user'){
					//show complete list of available collabprefs when pulling user data
					$row['collabpref'] = $this->collabpref( 'combined', $filter );
				} else {
					//show only existing collabprefs
					$row['collabpref'] = $this->collabpref( 'normal', $filter );
				}
			}

			//user's ideas
			if(strpos($structure, 'idea,') !== false){
				$structure_idea = explode('idea,', $structure);
				$row['idea'] = $this->idea('user', $filter, array(), $structure_idea[1]);
			}
			if(strpos($structure, 'num_of_ideas') !== false){
				$row['num_of_ideas'] = $this->count('users_ideas', $filter);
			}			

			//skill
			if(strpos($structure, 'skill') !== false){
				$row['skill'] = $this->skill( $filter );
			}

			//industry
			if(strpos($structure, 'industry') !== false){
				$row['industry'] = $this->industry( $filter );
			}
			
			//add link
			if(((isset($structure_idea) && strpos($structure_idea[0], 'link') !== false) ||
				(strpos($structure, 'link') !== false && !isset($structure_idea))
				&& $type != 'candidate')){

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

		return $array;
	}

	public function idea($type, $filter, $data = array(), $structure = ""){

		if( $type == 'recent_updated' ) {
			$sql =	"SELECT i.*, ist.name AS status, t.translation AS status_translation FROM ".
					"`idea` AS i ".

					"LEFT JOIN `idea_status` AS ist ".
					"ON ist.id = i.status_id ".

					"LEFT JOIN `translation` AS t ".
					"ON ist.id = t.row_id ".
					"AND t.table = 'idea_status' ".
					"AND t.language_id = {$filter['site_lang']} ".

					"WHERE i.deleted = 0 ";

			//set exclude ideas where query
			if(isset($filter['exclude'])){
				$sql.= " AND i.id != " . implode($filter['exclude'], " AND i.id != ")." ";
			}

			$sql.= 	"ORDER BY i.time_updated DESC ".
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
          
					"WHERE i.deleted = 0 ";

					$match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));
					if($match->id == $filter['match_id'] || Yii::app()->user->isAdmin()){
						$sql.=" OR i.deleted = 2 ";
					}

					$sql.="ORDER BY im.type_id ASC, i.time_registered DESC";

		} elseif( $type == 'idea' ){
			$sql=	"SELECT i.*, ist.name AS status, t.translation AS status_translation FROM ".
					"`idea` AS i ".

					"LEFT JOIN `idea_status` AS ist	".
					"ON i.status_id = ist.id ".

					"LEFT JOIN `translation` AS t ".
					"ON ist.id = t.row_id ".
					"AND t.table = 'idea_status' ".
					"AND t.language_id = {$filter['site_lang']} ".
					"WHERE i.id = '{$filter['idea_id']}' ";

					$match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));
					$ideamember = IdeaMember::Model()->findByAttributes(array('match_id' => $match->id, 'idea_id' => $filter['idea_id']));

					if($ideamember || Yii::app()->user->isAdmin()){
						$sql.=" AND (i.deleted = 2 OR i.deleted = 0)";
					} else {
						$sql.=" AND i.deleted = 0";
					}

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
			$condition = array();
			foreach( $data AS $key => $value ){
				$condition[] =	"i.id = {$value['id']}";
				$keys[] = $value['id'];
			}
			if(count($condition) == 0) return false;
			$sql.= implode($condition, " OR ") . " ) ORDER BY FIELD(i.id, ".implode($keys, ', ').") ASC";
		}

 		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$array = array();

		while(($row=$dataReader->read())!==false){
			
			//prepare filter
			$filter['idea_id'] = $row['id'];

			//idea status
			if(strlen($row['status_translation']) > 0){
				$row['status'] = $row['status_translation'];
			}
			unset($row['status_translation']);

			//time data
			$row['date_updated'] = Yii::app()->dateFormatter->formatDateTime(strtotime($row['time_updated']));
			$row['days_updated'] = floor( (time() - strtotime($row['time_updated'])) / 86400 );

			//translation..
			$merge = $this->idea_translation( 'userlang', $filter );
			if(isset($merge['language_id'])){
				$row = array_merge($row, $merge);
				$filter['default_lang'] = $merge['language_id'];
			} else {
				$filter['default_lang'] = $filter['lang'];
			}

			//translation_other
			if(strpos($structure, 'translation_other') !== false){
				$row['translation_other'] = $this->idea_translation( 'other', $filter );
			}

			//candidates
			if(strpos($structure, 'candidate') !== false){
				$structure_candidate = explode('candidate,', $structure);
				$row['candidate'] = $this->user('candidate', $filter, array(), $structure_candidate[1]);
			}

			//member
			if(strpos($structure, 'member') !== false){
				$row['member'] = $this->user( 'member', $filter );
			}
			//member count
			if(strpos($structure, 'num_of_members') !== false){
				$row['num_of_members'] = count($row['member']);
			}
			//add link
			if(strpos($structure, 'link') !== false){
				$row['link'] = $this->link( 'idea', $filter );
			}
			//gallery
			if(strpos($structure, 'gallery') !== false){
				$row['gallery'] = $this->gallery( $filter );
			}

			//add number of clicks
			if($filter['action'] == ('user' || 'idea')){
				$num_of_clicks = $this->count('idea_clicks', $filter);
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

	public function gallery($filter){

		$sql=		"SELECT ig.* FROM ".
					"`idea_gallery` AS ig ".
					"WHERE ig.idea_id = '{$filter['idea_id']}' ".
					"ORDER BY ig.cover DESC";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$array = array();

		while(($row=$dataReader->read())!==false) {
			$array[] = $row;
		}

		return $array;
	}

	public function collabpref($type, $filter){

		if($type == 'combined'){
			$sql=	"SELECT uc.id, collabpref.id AS collab_id, collabpref.name, t.translation, uc.collab_id AS active FROM collabpref LEFT JOIN ".
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

	public function skill($filter){

		$sql=		"SELECT s.id, s.name AS skill FROM ".
					"`user_skill` AS us ".
					"LEFT JOIN `skill` AS s ".
					"ON s.id = us.skill_id ".
					"WHERE us.match_id = '{$filter['match_id']}' ".
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

	public function industry($filter){

		$sql=		"SELECT i.id, i.name AS industry, t.translation FROM ".
					"`user_industry` AS ui ".
					"LEFT JOIN `industry` AS i ".
					"ON i.id = ui.industry_id ".
					"LEFT JOIN translation AS t ".
					"ON i.id = t.row_id ".
					"AND t.table = 'industry'".
					"AND t.language_id = '{$filter['site_lang']}'".
					"WHERE ui.match_id = '{$filter['match_id']}' ".
					"GROUP BY i.id";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$array = array();

		while(($row=$dataReader->read())!==false) {

			if(strlen($row['translation']) > 0){
				$row['industry'] = $row['translation'];
			}

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

	public function count($type, $filter){
		if($type == 'users'){
			//for pagination
			$sql=	"SELECT count(u.id) AS count FROM ".
					"`user` AS u 
           INNER JOIN `user_match` AS m ON u.id = m.user_id
          LEFT JOIN `user_stat` AS us ON u.id = us.user_id

           WHERE m.user_id > 0  AND u.status = 1 AND us.completeness >= ".PROFILE_COMPLETENESS_MIN;

		} elseif( $type == 'ideas' ){
			//for pagination
			$sql =	"SELECT count(i.id) as count FROM ".
					"`idea` AS i ".
					"WHERE i.deleted = 0 ";

		} elseif( $type == 'idea_clicks' ){
			//number of clicks for idea
			$sql =	"SELECT count(ci.id) as count FROM ".
					"`click_idea` AS ci ".
					"WHERE ci.idea_click_id = '{$filter['idea_id']}' ".
					"GROUP BY ci.idea_click_id";
		} elseif($type == 'users_ideas'){
			$sql=	"SELECT COUNT(i.id) AS count FROM ".
					"`idea` AS i ".

					"INNER JOIN `idea_member` AS im ".
					"ON i.id = im.idea_id ".
					"AND im.match_id = '{$filter['match_id']}' ".

					"WHERE i.deleted = 0 ".					
					"ORDER BY im.type_id ASC, i.time_registered DESC";
		}

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$array = array();
		
		$row=$dataReader->read();
		$array = $row['count'];
		
		return $array;
	}
/*
	public function events($filter){

		$sql=		"SELECT ig.* FROM ".
					"`idea_gallery` AS ig ".
					"WHERE ig.idea_id = '{$filter['idea_id']}' ".
					"ORDER BY ig.cover DESC";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$array = array();

		while(($row=$dataReader->read())!==false) {
			$array[] = $row;
		}

		return $array;
	}*/
}
