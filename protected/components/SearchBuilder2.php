<?php

class SearchBuilder2 {

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

		/*
		Simplification search-a:
			ideja: -keywords, država, extradetail, language
			uporabnik: -država
					   +ime
		*/

		$rank = array();

		if($type == 'user'){

			//signle number filter entry
				//available
					$rank = $this->singleEntry($rank, $filter, 'available', 'userAvailable');
				//collabpref
					$rank = $this->singleEntry($rank, $filter, 'collabpref', 'userCollabpref');
			//multiple text filter entries
				//city
					$rank = $this->multipleEntries($rank, $filter, 'city', 'userCity');
				//name
					$rank = $this->multipleEntries($rank, $filter, 'user', 'userNameSurname', " ");
				//skill
					$rank = $this->multipleEntries($rank, $filter, 'skill', 'userSkillsetTranslation');
					$rank = $this->multipleEntries($rank, $filter, 'skill', 'userSkillset');
					$rank = $this->multipleEntries($rank, $filter, 'skill', 'userSkill');

		} elseif( $type == 'idea' ){

			//signle number filter entry
				//available
					$rank = $this->singleEntry($rank, $filter, 'available', 'ideaAvailable');
				//collabpref
					$rank = $this->singleEntry($rank, $filter, 'collabpref', 'ideaCollabpref');
				//stage
					$rank = $this->singleEntry($rank, $filter, 'stage', 'ideaStage');
			//multiple text filter entries
				//city
					$rank = $this->multipleEntries($rank, $filter, 'city', 'ideaCity');
				//skill
					$rank = $this->multipleEntries($rank, $filter, 'skill', 'ideaSkillsetTranslation');
					$rank = $this->multipleEntries($rank, $filter, 'skill', 'ideaSkillset');
					$rank = $this->multipleEntries($rank, $filter, 'skill', 'ideaSkill');

		}

		$array = $rank['array'];
		$rank_array = $rank['rank_array'];
		$count = count($array);

		if($count > 0){

			//Sort by relevance
			array_multisort($rank_array, SORT_DESC, $array);

			//Pagination
			$array = array_slice($array, ($filter['page'] - 1) * $filter['per_page'], $filter['per_page']);
		
		}

		$return['count'] = $count;
		$return['results'] = $array;

		//print_r($return);

		return $return;
	}

	private function multipleEntries($rank, $filter, $key, $functionName, $delimiter = ","){
		
		if( isset($filter[$key]) && strlen($filter[$key]) > 0 ){
			$keyworder = new Keyworder;
			$strings = $keyworder->string2array($filter[$key], $delimiter);

			foreach($strings AS $key => $value){
				if(strlen($value) >= 2){
					$rank = $this->queryRank($this->$functionName(), "%".$value."%", $rank);
				}
			}
		}

		return $rank;
	}

	private function singleEntry($rank, $filter, $key, $functionName){

		if( isset($filter[$key]) && strlen($filter[$key]) > 0 ){
			$rank = $this->queryRank($this->$functionName(), $filter[$key], $rank);
		}

		return $rank;
	}

	private function queryRank($sql, $value, $rank = array()){

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$command->bindParam(":value", $value);
		$dataReader=$command->query();

		if(isset($rank['array'])){
			$array = $rank['array'];
		} else {
			$array = array();
		}
			
		if(isset($rank['rank_array'])){
			$rank_array = $rank['rank_array'];
		} else {
			$rank_array = array();
		}
			

		while(($row=$dataReader->read())!==false) {

			if($row['id'] > 0){
				if(isset($array[$row['id']]['rank']) && $array[$row['id']]['rank'] > 0){
					$array[$row['id']]['rank']++;
					$rank_array[$row['id']]++;
				} else {
					$array[$row['id']]['id'] = $row['id'];
					$array[$row['id']]['rank'] = 1;
					$rank_array[$row['id']] = 1;
				}
			}

		}

		$rank['array'] = $array;
		$rank['rank_array'] = $rank_array;

		return $rank;

	}

	private function userAvailable(){

		$sql = 	"SELECT m.id ".
				"FROM  `user_match` AS m ".
				"WHERE m.available = :value ".
				"AND m.user_id >0 ".
				"GROUP BY m.id";
		return $sql;

	}

	private function userCollabpref(){

		$sql = 	"SELECT m.id ".
				"FROM  `user_collabpref` AS c ".
				"LEFT JOIN `user_match` AS m ON m.id = c.match_id ".
				"WHERE c.collab_id = :value ".
				"AND m.user_id > 0 ".
				"GROUP BY m.id";
		return $sql;

	}

	private function userCity(){

		$sql = 	"SELECT m.id ".
				"FROM  `city` AS c ".
				"LEFT JOIN `user_match` AS m ON m.city_id = c.id ".
				"WHERE c.name LIKE :value ".
				"AND m.user_id >0 ".
				"GROUP BY m.id";
		return $sql;

	}

	private function userNameSurname(){

		$sql = 	"SELECT m.id ".
				"FROM  `user` AS u ".
				"LEFT JOIN `user_match` AS m ON m.user_id = u.id ".
				"WHERE u.name LIKE :value ".
				"OR u.surname LIKE :value ".
				"AND m.user_id >0 ".
				"GROUP BY m.id";
		return $sql;

	}

	private function userSkillsetTranslation(){

		$sql =	"SELECT m.id ".
				"FROM  `translation` AS tss ".
				"LEFT JOIN `skillset` AS ss ON tss.table = 'skillset' AND tss.row_id = ss.id ".
				"LEFT JOIN `user_skill` AS us ON ss.id = us.skillset_id ".
				"LEFT JOIN `user_match` AS m ON us.match_id = m.id ".
				"WHERE tss.translation LIKE :value ".
				"AND m.user_id >0 ".
				"GROUP BY m.id";
		return $sql;

	}

	private function userSkillset(){

		$sql =	"SELECT m.id ".
				"FROM  `skillset` AS ss ".
				"LEFT JOIN `user_skill` AS us ON ss.id = us.skillset_id ".
				"LEFT JOIN `user_match` AS m ON us.match_id = m.id ".
				"WHERE ss.name LIKE :value ".
				"AND m.user_id >0 ".
				"GROUP BY m.id";
		return $sql;

	}

	private function userSkill(){

		$sql =	"SELECT m.id ".
				"FROM  `skill` AS s ".
				"LEFT JOIN `user_skill` AS us ON s.id = us.skill_id ".
				"LEFT JOIN `user_match` AS m ON us.match_id = m.id ".
				"WHERE s.name LIKE :value ".
				"AND m.user_id >0 ".
				"GROUP BY m.id";
		return $sql;

	}

	private function ideaAvailable(){

		$sql =	"SELECT i.idea_id AS id ".
				"FROM  `user_match` AS m ".
				"LEFT JOIN `idea_member` AS i ON m.id = i.match_id ".
				"WHERE m.available = :value ".
				"AND m.user_id IS NULL ".
				"GROUP BY i.idea_id";
		return $sql;

	}

	private function ideaCity(){

		$sql = 	"SELECT i.idea_id AS id ".
				"FROM  `city` AS c ".
				"LEFT JOIN `user_match` AS m ON m.city_id = c.id ".
				"LEFT JOIN `idea_member` AS i ON m.id = i.match_id ".
				"WHERE c.name LIKE :value ".
				"AND m.user_id IS NULL ".
				"GROUP BY i.idea_id";
		return $sql;

	}

	private function ideaCollabpref(){

		$sql =	"SELECT i.idea_id AS id ".
				"FROM  `user_collabpref` AS c ".
				"LEFT JOIN `user_match` AS m ON m.id = c.match_id ".
				"LEFT JOIN `idea_member` AS i ON i.match_id = m.id ".
				"WHERE c.collab_id = :value ".
				"AND m.user_id IS NULL ".
				"GROUP BY i.idea_id";
		return $sql;

	}

	private function ideaSkillsetTranslation(){

		$sql =	"SELECT i.idea_id AS id ".
				"FROM  `translation` AS tss ".
				"LEFT JOIN `skillset` AS ss ON tss.table = 'skillset' AND tss.row_id = ss.id ".
				"LEFT JOIN `user_skill` AS us ON ss.id = us.skillset_id ".
				"LEFT JOIN `user_match` AS m ON us.match_id = m.id ".
				"LEFT JOIN `idea_member` AS i ON i.match_id = m.id ".
				"WHERE tss.translation LIKE :value ".
				"AND m.user_id IS NULL ".
				"GROUP BY i.idea_id";
		return $sql;

	}

	private function ideaSkillset(){

		$sql =	"SELECT i.idea_id AS id ".
				"FROM  `skillset` AS ss ".
				"LEFT JOIN `user_skill` AS us ON ss.id = us.skillset_id ".
				"LEFT JOIN `user_match` AS m ON us.match_id = m.id ".
				"LEFT JOIN `idea_member` AS i ON i.match_id = m.id ".
				"WHERE ss.name LIKE :value ".
				"AND m.user_id IS NULL ".
				"GROUP BY i.idea_id";
		return $sql;

	}

	private function ideaSkill(){

		$sql =	"SELECT i.idea_id AS id ".
				"FROM  `skill` AS s ".
				"LEFT JOIN `user_skill` AS us ON s.id = us.skill_id ".
				"LEFT JOIN `user_match` AS m ON us.match_id = m.id ".
				"LEFT JOIN `idea_member` AS i ON i.match_id = m.id ".
				"WHERE s.name LIKE :value ".
				"AND m.user_id IS NULL ".
				"GROUP BY i.idea_id";
		return $sql;

	}

	private function ideaStage(){

		$sql=	"SELECT i.id AS id ".
				"FROM `idea` AS i ".
				"WHERE i.status_id = :value ". 
				"GROUP BY i.id";
		return $sql;

	}

}

?>