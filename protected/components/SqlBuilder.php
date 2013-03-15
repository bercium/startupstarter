<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class SqlBuilder {

	public function idea($type, $filter = 0){
		/*
		type
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
						"`idea` AS i, `idea_status` AS ist, `idea_member` AS im, `user` AS u ".
						"WHERE i.ID = im.idea_id ".
						"AND i.status_id = ist.ID ".
						"AND i.deleted = 0 ".
						"AND im.user_id = u.ID ".
						"AND u.deleted = 0 ".
						"AND u.VIRTUAL = 1 ".
						"ORDER BY u.time_registered DESC";

			/*
			ADDITIONAL FILTERS FIR SKILL(SETS), collabpref, 
					AND u.available = 1 
					AND uc.ID = ( '{$_POST['collab_id']}' || ... ) 
					AND ( us.skillset_id = ( '{$_POST['skillset_id']}'' || ... ) OR us.skill_id = ( '{$_POST['skillset_id']}' || ... ) ) 
			}*/
		} elseif( $type == 'user' ) {
			$sql=	"SELECT i.*, ist.name AS status FROM ".
					"`idea` AS i, `idea_status` AS ist, `idea_member` AS im, `user` AS u ".
					"WHERE i.ID = im.idea_id ".
					"AND i.status_id = ist.ID ".
					"AND i.deleted = 0 ".
					"AND im.user_id = u.ID ".
					"AND u.deleted = 0 ".
					"AND u.ID = '{$filter['user_id']}' ".
					"ORDER BY i.time_registered DESC";
		} elseif( $type == 'idea' ){
			$sql=	"SELECT i.*, ist.name AS status FROM ".
					"`idea` AS i, `idea_status` AS ist, `idea_member` AS im, `user` AS u ".
					"WHERE i.ID = im.idea_id ".
					"AND i.status_id = ist.ID ".
					"AND i.deleted = 0 ".
					"AND im.user_id = u.ID ".
					"AND u.deleted = 0 ".
					"AND i.ID = '{$filter['idea_id']}' ".
					"ORDER BY i.time_registered DESC";
		}
		
 		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		//read data, build array, call contained functions
		$array = NULL;
		while(($row=$dataReader->read())!==false) {
			$array[$row['ID']] = $row;
			$array[$row['ID']]['translation'] = $this->translation( array('idea_id' => $row['ID']));
			$array[$row['ID']]['members'] = $this->user( 'members', array('idea_id' => $row['ID']));
			$array[$row['ID']]['candidates'] = $this->user( 'candidates', array('idea_id' => $row['ID']));
		}

		return $array;
	}

	public function translation($filter){
		$sql=		"SELECT it.* FROM ".
					"`idea` AS i, ".
					"`idea_translation` AS it ".
					"WHERE i.ID = it.idea_id ".
					"AND it.idea_id = {$filter['idea_id']}";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		//read data, build array, call contained functions
		$array = NULL;
		while(($row=$dataReader->read())!==false) {
			$array[$row['ID']] = $row;
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
			$sql=	"SELECT u.* FROM ".
					"`user` AS u ".
					"WHERE u.deleted = 0 ".
					"AND u.VIRTUAL = 0 ".
					"ORDER BY u.time_registered DESC";
		} elseif( $type == 'members' ) {
			$sql=	"SELECT u.* FROM ".
					"`idea_member` AS im, ".
					"`user` AS u ".
					"WHERE im.user_id = u.ID ".
					"AND u.deleted = 0 ".
					"AND u.VIRTUAL = 0 ".
					"AND im.idea_id = '{$filter['idea_id']}' ".
					"ORDER BY im.type DESC";
		} elseif( $type == 'candidates' ) {
			$sql=	"SELECT u.* FROM ".
					"`idea_member` AS im, ".
					"`user` AS u ".
					"WHERE im.user_id = u.ID ".
					"AND u.deleted = 0 ".
					"AND u.VIRTUAL = 1 ".
					"AND im.idea_id = '{$filter['idea_id']}' ".
					"ORDER BY u.time_registered DESC";
		} elseif( $type == 'user' ) {
			$sql=	"SELECT u.* FROM ".
					"`user` AS u ".
					"AND u.deleted = 0 ".
					"AND u.VIRTUAL = 0 ".
					"AND u.user_id = '{$filter['user_id']}'";
		}

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		//read data, build array, call contained functions
		$array = NULL;
		while(($row=$dataReader->read())!==false) {
			$array[$row['ID']] = $row;
			$array[$row['ID']]['collabpref'] = $this->collabpref( array('user_id' => $row['ID']) );
			$array[$row['ID']]['skillset'] = $this->skillset( array('user_id' => $row['ID']) );
			if($type == 'user'){
				$array[$row['ID']]['idea'] = $this->idea( array('user_id' => $filter['user_id']) );
			}
			$array[$row['ID']]['link'] = $this->link( array('user_id' => $row['ID']) );
		}

		return $array;
	}

	public function collabpref($filter){
		$sql=		"SELECT c.* FROM ".
					"`collabpref` AS c, ".
					"`user_collabpref` AS uc ".
					"WHERE uc.collab_id = c.ID ".
					"AND uc.user_id = '{$filter['user_id']}'";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		//read data, build array, call contained functions
		$array = NULL;
		while(($row=$dataReader->read())!==false) {
			$array[$row['ID']] = $row;
		}

		return $array;
	}

	public function skillset($filter){
		$sql=		"SELECT ss.* FROM ".
					"`skillset` AS ss, ".
					"`user_skill` AS us ".
					"WHERE ss.ID = us.skillset_id ".
					"AND us.user_id = '{$filter['user_id']}'";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		//read data, build array, call contained functions
		$array = NULL;
		while(($row=$dataReader->read())!==false) {
			$array[$row['ID']] = $row;
			$array[$row['ID']]['skill'] = $this->skill( array('user_id' => $filter['user_id'], 'skillset_id' => $row['ID']) );
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
					"WHERE s.ID = us.skill_id ".
					"AND us.skillset_id = '{$filter['skillset_id']}' ".
					"AND us.user_id = '{$filter['user_id']}'";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		//read data, build array, call contained functions
		$array = NULL;
		while(($row=$dataReader->read())!==false) {
			$array[$row['ID']] = $row;
		}

		return $array;
	}

	public function link($filter){
		$sql=		"SELECT l.* FROM ".
					"`link` AS l, ".
					"`user_link` AS ul ".
					"WHERE ul.link_id = l.ID ".
					"AND ul.user_id = '{$filter['user_id']}'";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		//read data, build array, call contained functions
		$array = NULL;
		while(($row=$dataReader->read())!==false) {
			$array[$row['ID']] = $row;
		}

		return $array;
	}
}