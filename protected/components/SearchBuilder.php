<?php

class SearchBuilder {

	public function search($type, $filter){

		/*Taking in from $filter[] and processing data into sql;
		There's more than one user_match row per idea... We'll group by idea_id in case of idea
		
		Input data structure (word is table, -field is $key)

		idea_keyword ---($k rows) -> $filter['keyword'];
			-keyword

		idea -> $filter['extra'];
			-website
			-video_link
		
		idea_status -> $filter['status'] = $value;
			-status_id

		user_match -> $filter['$key'] = '$value';
			-country_id
			-city_id
			-available

		user_collabpref ---($c rows) -> $filter['collabpref'][N] = '$value';

		user_skill  ---($ss rows) -> $filter['skill'][N]['$key'];
			-id
			-type = 1

		user_skill  ---($s rows) -> $filter['skill'][N]['$key'];
			-id = $value
			-type = 2

		user ---($u rows) -> $filter['user'];
			-name
			-surname
		*/

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
		if(isset($filter['skill']) && strlen($filter['skill']) > 0){

			//break up into keywords
			$keyworder = new Keyworder;
			$skills = $keyworder->string2array($filter['skill']);

			unset($filter['skillset']);
			unset($filter['skillset_skill']);

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
		if( isset($filter['keywords']) && strlen($filter['keywords']) > 0){
			$keyworder = new Keyworder;
			$keywords = $keyworder->string2array($filter['keywords']);

			unset($filter['keyword']);

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
		if( isset($filter['user']) && strlen($filter['user']) > 0){
			$keyworder = new Keyworder;
			$user = $keyworder->string2array($filter['user'], " ");

			unset($filter['user']);

			foreach($user AS $key => $value){

				if(strlen($value) >= 2){
					$value = addcslashes($value, '%_'); // escape LIKE's special characters
					$condition = new CDbCriteria( array(
					    'condition' => "`name` LIKE :value OR `surname` LIKE :value",         // no quotes around :match
					    'params'    => array(':value' => "%".$value."%")  // Aha! Wildcards go here
					) );

					$dataReader = User::Model()->findAll( $condition );

					foreach($dataReader AS $row){
						$filter['user'][] = $row['id'];
					}
				}
			}
		}
		if( isset($filter['stage']) && is_numeric($filter['stage']) ){
			$filter['status_id'] = $filter['stage'];
		}

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

			//idea_translation AS it
			if(isset($filter['language']) AND is_numeric($filter['language'])){
				$sql.=	"it.language_id, ";
			}
		}

		//only for user
		if($type == "user"){
			//user AS u
			if( isset($filter['user']) && is_array($filter['user']) && count($filter['user']) > 0 ){
				$u = -1;
				foreach($filter['user'] AS $key => $value){
					$u++;
					$sql.= "u{$u}.id AS u{$u}_id, ";
				}
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

		//user_collabpref AS c
		if( isset($filter['collabpref']) && is_numeric($filter['collabpref']) ){
			$sql.=	"c.id AS collab_id, ";
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
		$where = array();

		if($type == "idea"){
			//idea_keyword AS k
			if( isset($filter['keyword']) && is_array($filter['keyword']) && count($filter['keyword']) > 0 ){
				$k = -1;
				foreach($filter['keyword'] AS $key => $value){
					//$VALUE INPUT VALIDATION NEEDED
					$k++;
					$sql.= "LEFT JOIN `keyword` AS k{$k} ON 
								k{$k}.table = 'idea_translation' 
								AND k{$k}.row_id = i.id 
								AND k{$k}.id = :k{$k}_id ";
					$cols["k{$k}_id"] = $value; //this key is an _id here, but it's really a string
					$where['keyword']["k{$k}.id"] = $value;
				}
			}

			//idea AS i
			//the following field does not require joins, we're merely preparing variables for result ranking
			if(isset($filter['status_id']) AND is_numeric($filter['status_id'])){
				$cols["status_id"] = $filter['status_id'];
				$where['stage']['i.status_id'] = $filter['status_id'];
			}
			if(isset($filter['extra']) && $filter['extra'] == 1){
				$cols["website"] = "";
				$cols["video_link"] = "";
				$where['extra']['i.website'] = NULL;
				$where['extra']['i.video_link'] = NULL;
			}

			//language
			if(isset($filter['language']) AND is_numeric($filter['language'])){
				$sql.= "LEFT JOIN `idea_translation` AS it ON 
							it.idea_id = i.id ";
				$cols["language_id"] = $filter['language'];
				$where['language']['it.id'] = $filter['language'];
			}
		}

		if($type == 'user'){
			//user AS u
			if( isset($filter['user']) && is_array($filter['user']) && count($filter['user']) > 0 ){
				$u = -1;
				foreach($filter['user'] AS $key => $value){
					//$VALUE INPUT VALIDATION NEEDED
					$u++;
					$sql.= "LEFT JOIN `user` AS u{$u} ON  
								u{$u}.id = m.user_id 
								AND u{$u}.id = :u{$u}_id ";
					$cols["u{$u}_id"] = $value; //this key is an _id here, but it's really a string
					$where['user']["u{$u}.id"] = $value;
				}
			}
		}

		//user_match AS m
			//the following field does not require joins, we're merely preparing variables for result ranking
		if(isset($filter['available']) AND is_numeric($filter['available'])){
			$cols["available"] = $filter['available'];
			$where['available']['m.available'] = $filter['available'];
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
					$where['country']['m.country_id'] = $value;
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
					$where['city']['m.city_id'] = $value;
				}
			}
		}

		//user_collabpref AS c
		if( isset($filter['collabpref']) && is_numeric($filter['collabpref']) ){
			$sql.= "LEFT JOIN `user_collabpref` AS c ON 
								c.match_id = m.id 
								AND c.id = :collab_id ";
			$cols["collab_id"] = $filter['collabpref'];
			$where['collabpref']['c.id'] = $filter['collabpref'];
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
					$where['skillset']["ms{$ms}.skillset_id"] = $value;
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
					$where['skillset_skill']["mss{$mss}.skill_id"] = $value;
				}
			}
		}


		//WHERE SENTENCES
		//first prepare the conditions based on $cols
		$where_sql = "";
		if(isset($filter['category']) && is_array($filter['category'])){
			foreach($filter['category'] AS $key => $value){
				$buffer = array();
				if(isset($where[$value]) AND is_array($where[$value])){
					if($value == 'extra') {
						$where_sql.="AND (i.website OR i.video_link) ";
					} elseif($value == 'collabpref') {
						$where_sql.="AND (c.id = ".$where['collabpref']['c.id'].") ";
					} else {
						$where_sql.="AND (";
						foreach($where[$value] AS $key1 => $value1){
							$buffer[] = $key1 . " = " . $value1;
						}
						$where_sql.= implode(' OR ', $buffer) . ") ";
					}
				} else {
					if($value == 'skill'){
						if(isset($where['skillset'])){
							$where_sql.="AND (";
							foreach($where['skillset'] AS $key1 => $value1){
								$buffer[] = $key1 . " = " . $value1;
							}
							$where_sql.= implode(' OR ', $buffer) . ") ";
						}
						if(isset($where['skillset_skill'])){
							$buffer = array();
							$where_sql.="AND (";
							foreach($where['skillset_skill'] AS $key1 => $value1){
								$buffer[] = $key1 . " = " . $value1;
							}
							$where_sql.= implode(' OR ', $buffer) . ") ";
						}
					}
				}
			}
		}

		if($type == "idea") {
			//group by idea_id
			//because it's highly relevant if one person has skills sought in several candidates
			$sql.=	" WHERE i.deleted = 0 " . $where_sql . " GROUP BY i.id";
		} elseif($type == "user") {
			$sql.=	" WHERE m.user_id > 0 " . $where_sql . " GROUP BY m.id";
		}

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
		$count = 0;

		/*rank results by matching fields and a ranking system*/
		$total = count($cols_backup); //each field is worth 1 point right now

		while(($row=$dataReader->read())!==false) {

			$rank = 0;
			if($total > 0){

				foreach($cols_backup AS $key => $value){
					
					if(	$key == "status_id" || 
						$key == "available" ||
						$key == "language_id" ){

						if($row[$key] == $value){
							$rank++;
						}
					} elseif( $key == "website" || 
						$key == "video_link" ){

						//!!!isurl regex
						if(strlen($row[$key]) > 3){
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

			if($rank > 0){
				$array[$row['id']] = $row;
				$array[$row['id']]['rank'] = $rank;

				$rank_array[$row['id']] = $rank;

				$count++;
			}
		}
		
		if($count > 0){
			//Sort by relevance
			array_multisort($rank_array, SORT_DESC, $array);

			//Pagination
			$array = array_slice($array, ($filter['page'] - 1) * $filter['per_page'], $filter['per_page']);
		}
		
		
		//DEBUG
		echo $type."\n";
		echo "# of conditions: $total\n";
		//print_r($cols_backup);
		print_r($where);
		echo $sql;
		print_r($array);
		

		//Load the array with data!
		$return['count'] = $count;
		$return['results'] = $array;
		return $return;
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