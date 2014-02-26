<?php

class SearchBuilder2 {

	public function search($type, $filter, $where = ""){
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

		/*$where user:
			-search by user_match, user table variables

		  $where idea:
		  	-search by idea table variables*/

		$rank = array();
		$array = array();

		if($type == 'user'){

			//set exclude users where query
			if(isset($filter['exclude'])){
				$where.= " AND u.id != " . implode($filter['exclude'], " AND u.id != ");
			}

			//number filter entries
				//available
					$rank = $this->numberEntries($rank, $filter, 'available', 'userAvailable', $where);
				//collabpref
					$rank = $this->numberEntries($rank, $filter, 'collabpref', 'userCollabpref', $where);
			//text filter entries
				//city
					$rank = $this->textEntries($rank, $filter, 'city', 'userCity', $where);
				//name
					$rank = $this->textEntries($rank, $filter, 'user', 'userNameSurname', $where, " ");
				//skill
					$rank = $this->textEntries($rank, $filter, 'skill', 'userSkillsetTranslation', $where);
					$rank = $this->textEntries($rank, $filter, 'skill', 'userSkillset', $where);
					$rank = $this->textEntries($rank, $filter, 'skill', 'userSkill', $where);
			//recent users call
					$rank = $this->textEntries($rank, $filter, 'recent', 'userRecent', $where);

		} elseif( $type == 'idea' ){

			//set exclude ideas where query
			if(isset($filter['exclude'])){
				$where.= " AND i.id != " . implode($filter['exclude'], " AND i.id != ");
			}

			//number filter entries
				//available
					$rank = $this->numberEntries($rank, $filter, 'available', 'ideaAvailable', $where);
				//collabpref
					$rank = $this->numberEntries($rank, $filter, 'collabpref', 'ideaCollabpref', $where);
				//stage
					$rank = $this->numberEntries($rank, $filter, 'stage', 'ideaStage', $where);
			//text filter entries
				//city
					$rank = $this->textEntries($rank, $filter, 'city', 'ideaCity', $where);
				//skill
					$rank = $this->textEntries($rank, $filter, 'skill', 'ideaSkillsetTranslation', $where);
					$rank = $this->textEntries($rank, $filter, 'skill', 'ideaSkillset', $where);
					$rank = $this->textEntries($rank, $filter, 'skill', 'ideaSkill', $where);
			//recent ideas call
					$rank = $this->textEntries($rank, $filter, 'recent', 'ideaRecent', $where);
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

	private function textEntries($rank, $filter, $key, $functionName, $where, $delimiter = ","){
		
		if( isset($filter[$key]) && strlen($filter[$key]) > 0 ){
			$keyworder = new Keyworder;
			$strings = $keyworder->string2array($filter[$key], $delimiter);

			foreach($strings AS $key => $value){
				if(strlen($value) >= 2){
					$rank = $this->queryRank($this->$functionName($where), "%".$value."%", $rank);
				}
			}
		}

		return $rank;
	}

	private function numberEntries($rank, $filter, $key, $sqlFunctionName, $where, $delimiter = ","){

		if( isset($filter[$key]) && strlen($filter[$key]) > 0 ){

			$keyworder = new Keyworder;
			$numbers = $keyworder->string2array($filter[$key], $delimiter);

			foreach($numbers AS $key => $value){
				if(strlen($value) >= 1){
					$rank = $this->queryRank($this->$sqlFunctionName($where), $value, $rank);
				}
			}
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

	private function userAvailable($where = ""){

		$sql = 	"SELECT m.id ".
				"FROM  `user_match` AS m ".
				"LEFT JOIN `user` AS u ON m.user_id = u.id ".
				"LEFT JOIN `user_stat` AS ustat ON u.id = ustat.user_id ".
				"WHERE m.available = :value ".
				"AND m.user_id >0 ".
				"AND ustat.completeness >= ".PROFILE_COMPLETENESS_MIN." ".
				$where." ".
				"GROUP BY m.id";
		return $sql;

	}

	private function userCollabpref($where = ""){

		$sql = 	"SELECT m.id ".
				"FROM  `user_collabpref` AS c ".
				"LEFT JOIN `user_match` AS m ON m.id = c.match_id ".
				"LEFT JOIN `user` AS u ON m.user_id = u.id ".
				"LEFT JOIN `user_stat` AS ustat ON u.id = ustat.user_id ".
				"WHERE c.collab_id = :value ".
				"AND m.user_id > 0 ".
				"AND ustat.completeness >= ".PROFILE_COMPLETENESS_MIN." ".
				$where." ".
				"GROUP BY m.id";
		return $sql;

	}

	private function userCity($where = ""){

		$sql = 	"SELECT m.id ".
				"FROM  `city` AS c ".
				"LEFT JOIN `user_match` AS m ON m.city_id = c.id ".
				"LEFT JOIN `user` AS u ON m.user_id = u.id ".
				"LEFT JOIN `user_stat` AS ustat ON u.id = ustat.user_id ".
				"WHERE c.name LIKE :value ".
				"AND m.user_id >0 ".
				"AND ustat.completeness >= ".PROFILE_COMPLETENESS_MIN." ".
				$where." ".
				"GROUP BY m.id";
		return $sql;

	}

	private function userNameSurname($where = ""){

		$sql = 	"SELECT m.id ".
				"FROM  `user` AS u ".
				"LEFT JOIN `user_match` AS m ON m.user_id = u.id ".
				"LEFT JOIN `user_stat` AS ustat ON u.id = ustat.user_id ".
				"WHERE u.name LIKE :value ".
				"OR u.surname LIKE :value ".
				"AND m.user_id >0 ".
				"AND ustat.completeness >= ".PROFILE_COMPLETENESS_MIN." ".
				$where." ".
				"GROUP BY m.id";
		return $sql;

	}

	private function userRecent($where = ""){

		$sql = 	"SELECT m.id ".
				"FROM  `user` AS u ".
				"LEFT JOIN `user_match` AS m ON m.user_id = u.id ".
				"LEFT JOIN `user_stat` AS ustat ON u.id = ustat.user_id ".
				"WHERE m.user_id >0 ".
				"AND ustat.completeness >= ".PROFILE_COMPLETENESS_MIN." ".
				$where." ".
				"GROUP BY m.id ".
				"ORDER BY u.create_at DESC";
		return $sql;

	}

	private function userSkillsetTranslation($where = ""){

		$sql =	"SELECT m.id ".
				"FROM  `translation` AS tss ".
				"LEFT JOIN `skillset` AS ss ON tss.table = 'skillset' AND tss.row_id = ss.id ".
				"LEFT JOIN `user_skill` AS us ON ss.id = us.skillset_id ".
				"LEFT JOIN `user_match` AS m ON us.match_id = m.id ".
				"LEFT JOIN `user` AS u ON m.user_id = u.id ".
				"LEFT JOIN `user_stat` AS ustat ON u.id = ustat.user_id ".
				"WHERE tss.translation LIKE :value ".
				"AND m.user_id >0 ".
				"AND ustat.completeness >= ".PROFILE_COMPLETENESS_MIN." ".
				$where." ".
				"GROUP BY m.id";
		return $sql;

	}

	private function userSkillset($where = ""){

		$sql =	"SELECT m.id ".
				"FROM  `skillset` AS ss ".
				"LEFT JOIN `user_skill` AS us ON ss.id = us.skillset_id ".
				"LEFT JOIN `user_match` AS m ON us.match_id = m.id ".
				"LEFT JOIN `user` AS u ON m.user_id = u.id ".
				"LEFT JOIN `user_stat` AS ustat ON u.id = ustat.user_id ".
				"WHERE ss.name LIKE :value ".
				"AND m.user_id >0 ".
				"AND ustat.completeness >= ".PROFILE_COMPLETENESS_MIN." ".
				$where." ".
				"GROUP BY m.id";
		return $sql;

	}

	private function userSkill($where = ""){

		$sql =	"SELECT m.id ".
				"FROM  `skill` AS s ".
				"LEFT JOIN `user_skill` AS us ON s.id = us.skill_id ".
				"LEFT JOIN `user_match` AS m ON us.match_id = m.id ".
				"LEFT JOIN `user` AS u ON m.user_id = u.id ".
				"LEFT JOIN `user_stat` AS ustat ON u.id = ustat.user_id ".
				"WHERE s.name LIKE :value ".
				"AND m.user_id >0 ".
				"AND ustat.completeness >= ".PROFILE_COMPLETENESS_MIN." ".
				$where." ".
				"GROUP BY m.id";
		return $sql;

	}

	private function ideaAvailable($where = ""){

		$sql =	"SELECT im.idea_id AS id ".
				"FROM  `user_match` AS m ".
				"LEFT JOIN `idea_member` AS im ON m.id = im.match_id ".
				"LEFT JOIN `idea` AS i ON i.id = im.idea_id ".
				"WHERE m.available = :value ".
				"AND m.user_id IS NULL ".
				$where." ".
				"GROUP BY im.idea_id";
		return $sql;

	}

	private function ideaCity($where = ""){

		$sql = 	"SELECT im.idea_id AS id ".
				"FROM  `city` AS c ".
				"LEFT JOIN `user_match` AS m ON m.city_id = c.id ".
				"LEFT JOIN `idea_member` AS im ON m.id = im.match_id ".
				"LEFT JOIN `idea` AS i ON i.id = im.idea_id ".
				"WHERE c.name LIKE :value ".
				"AND m.user_id IS NULL ".
				$where." ".
				"GROUP BY im.idea_id";
		return $sql;

	}

	private function ideaCollabpref($where = ""){

		$sql =	"SELECT im.idea_id AS id ".
				"FROM  `user_collabpref` AS c ".
				"LEFT JOIN `user_match` AS m ON m.id = c.match_id ".
				"LEFT JOIN `idea_member` AS im ON im.match_id = m.id ".
				"LEFT JOIN `idea` AS i ON i.id = im.idea_id ".
				"WHERE c.collab_id = :value ".
				"AND m.user_id IS NULL ".
				$where." ".
				"GROUP BY im.idea_id";
		return $sql;

	}

	private function ideaRecent($where = ""){

		$sql=	"SELECT i.id AS id ".
				"FROM `idea` AS i ".
				"WHERE i.id > 0 ".
				$where." ".
				"ORDER BY i.time_registered DESC";
		return $sql;

	}

	private function ideaSkillsetTranslation($where = ""){

		$sql =	"SELECT im.idea_id AS id ".
				"FROM  `translation` AS tss ".
				"LEFT JOIN `skillset` AS ss ON tss.table = 'skillset' AND tss.row_id = ss.id ".
				"LEFT JOIN `user_skill` AS us ON ss.id = us.skillset_id ".
				"LEFT JOIN `user_match` AS m ON us.match_id = m.id ".
				"LEFT JOIN `idea_member` AS im ON im.match_id = m.id ".
				"LEFT JOIN `idea` AS i ON i.id = im.idea_id ".
				"WHERE tss.translation LIKE :value ".
				"AND m.user_id IS NULL ".
				$where." ".
				"GROUP BY im.idea_id";
		return $sql;

	}

	private function ideaSkillset($where = ""){

		$sql =	"SELECT im.idea_id AS id ".
				"FROM  `skillset` AS ss ".
				"LEFT JOIN `user_skill` AS us ON ss.id = us.skillset_id ".
				"LEFT JOIN `user_match` AS m ON us.match_id = m.id ".
				"LEFT JOIN `idea_member` AS im ON im.match_id = m.id ".
				"LEFT JOIN `idea` AS i ON i.id = im.idea_id ".
				"WHERE ss.name LIKE :value ".
				"AND m.user_id IS NULL ".
				$where." ".
				"GROUP BY im.idea_id";
		return $sql;

	}

	private function ideaSkill($where = ""){

		$sql =	"SELECT im.idea_id AS id ".
				"FROM  `skill` AS s ".
				"LEFT JOIN `user_skill` AS us ON s.id = us.skill_id ".
				"LEFT JOIN `user_match` AS m ON us.match_id = m.id ".
				"LEFT JOIN `idea_member` AS im ON im.match_id = m.id ".
				"LEFT JOIN `idea` AS i ON i.id = im.idea_id ".
				"WHERE s.name LIKE :value ".
				"AND m.user_id IS NULL ".
				$where." ".
				"GROUP BY im.idea_id";
		return $sql;

	}

	private function ideaStage($where = ""){

		$sql=	"SELECT i.id AS id ".
				"FROM `idea` AS i ".
				"WHERE i.status_id = :value ". 
				$where;
		return $sql;

	}

}

?>