<?php

class IdeaController extends GxController {

	public $data = array();
	public $layout="//layouts/view";
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
        'actions'=>array("view","recent"),
				'users'=>array('*'),
			),
	    array('allow',
		        'actions'=>array('create','edit'),
		        'users'=>array("@"),
		    ),
			array('allow', // allow admins only
				'users'=>Yii::app()->getModule('user')->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex($lang = NULL) {
		/*echo 'Links: <br/><br/>
		/ -> list ideas
		/create -> create new idea <br/>
		/$id -> view idea by id <br/>
		/$id?lang=$language_code -> view idea by id and language code (2 letter code, sl/en/..) <br/>
		/edit/$id -> edit idea by id <br/>
		/edit/$id?lang=$language_code -> edit idea by id and language code (2 letter code, sl/en/..) <br/>
		/deleteIdea/$id -> delete idea by id <br/>
		/translate/$id -> add translation by idea id <br/>
		/editTranslation/$id?lang=$language_code -> edit translation by idea id and language code (2 letter code, sl/en/..) <br/>
		/deleteTranslation/$id&lang=$lang -> delete translation by idea id and language code (2 letter code, sl/en/..) <br/>
		/addMember/$id -> add member to idea <br/>
		/editMember/$id?member_id=$match_id -> edit member by idea id and member id (actually match_id)<br/>
		/deleteMember/$id?member_id=$match_id -> delete member by idea id and member id (actually match_id) <br/>
		/addCandidate/$id -> add candidate to idea <br/>
		/editCandidate/$id&candidate_id=$match_id -> edit candidate by idea id and candidate_id (actually match_id)<br/>
		/deleteCandidate/$id&candidate_id=$match_id -> delete candidate by idea id and candidate_id (actually match_id)<br/>
		/addCollabpref/$id&candidate_id=$match_id -> add collabpref by idea id, candidate_id (actually match_id)<br/>
		/deleteCollabpref/$id&candidate_id=$match_id&collab_id=$usercollab_id -> delete collabpref by idea id, candidate_id (actually match_id), collab_id<br/>
		/addSkill/$id -> add skill by idea id, candidate_id (actually match_id)<br/>
		/deleteSkill/$id&candidate_id=$match_id&skill_id=$userskill_id -> delete skill by idea id, candidate_id (actually match_id), skill_id<br/>
		<br/>';*/

		$filter = Yii::app()->request->getQuery('filter', array());
		
		$sqlbuilder = new SqlBuilder;
		if($lang){
			$filter['lang'] = $lang;
		}

		$data['idea'] = $sqlbuilder->load_array("idea", $filter);

		$this->render('index', array('data' => $data));
	}

	public function actionView($id, $lang = NULL) {
		
		$sqlbuilder = new SqlBuilder;
		$filter = array( 'idea_id' => $id);
		if($lang){
			$filter['lang'] = $lang;
		}

		$data['idea'] = $sqlbuilder->load_array("idea", $filter);

		$this->render('view', array('data' => $data));

		//log clicks
		$click = new Click;
		$click->idea($id, Yii::app()->user->id);
	}

	public function actionCreate(){
		$this->layout="//layouts/edit";

		//insert data
		$idea = new Idea;
		$translation = new IdeaTranslation;
		$member = new IdeaMember;

		//we need this
		$user_id = Yii::app()->user->id;
		$match = UserMatch::Model()->findByAttributes( array( 'user_id' => $user_id ) );

		if (isset($_POST['Idea']) AND isset($_POST['IdeaTranslation'])) {
			$_POST['Idea']['time_updated'] = time();
			$idea->setAttributes($_POST['Idea']);

			if ($idea->save()) {

				$_POST['IdeaTranslation']['idea_id'] = $idea->id;
				$translation->setAttributes($_POST['IdeaTranslation']);

 				$_POST['IdeaMember']['idea_id'] = $idea->id;
 				$_POST['IdeaMember']['match_id'] = $match->id;
 				$_POST['IdeaMember']['type_id'] = 1;
				$member->setAttributes($_POST['IdeaMember']);

				if ($translation->save() && $member->save()) {

					if (Yii::app()->getRequest()->getIsAjaxRequest())
						Yii::app()->end();
					else
						$this->redirect(array('idea/edit', 'id' => $idea->id));
				}
			}
		}

		//for sidebar purposes
		$sqlbuilder = new SqlBuilder;
		$user_id = Yii::app()->user->id;
		$filter['user_id'] = $user_id;
		unset($filter['lang']);
		$data['user'] = $sqlbuilder->load_array("user", $filter);
		$this->data = $data;
		//for idea form purposes
		$user = UserEdit::Model()->findByAttributes( array( 'id' => $user_id ) );

		$this->render('createidea', array( 'idea' => $idea, 'translation' => $translation, 'user' => $user ));
	}

	public function actionEdit($id, $lang = NULL) { //can take different languages to edit
		$this->layout="//layouts/edit";

		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );

		$match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));
		$criteria=new CDbCriteria();
		$criteria->addInCondition('type_id',array(1,2)); //members
		$hasPriviledges = IdeaMember::Model()->findByAttributes(array('match_id' => $match->id, 'idea_id' => $id), $criteria);

		if($idea && $hasPriviledges){

			$sqlbuilder = new SqlBuilder;
			$filter = array( 'idea_id' => $id);

			if($lang){
				$language = Language::Model()->findByAttributes( array( 'language_code' => $lang ) );
				$translation = IdeaTranslation::Model()->findByAttributes( array( 'idea_id' => $idea->id, 'language_id' => $language->id, 'deleted' => 0 ) );

				$filter['lang'] = $lang;
			} else {
				$translation = IdeaTranslation::Model()->findByAttributes( array( 'idea_id' => $idea->id, 'deleted' => 0 ) );
			}

			if (isset($_POST['Idea']) AND isset($_POST['IdeaTranslation'])) {
				$_POST['time_updated'] = time();
				$idea->setAttributes($_POST['Idea']);

				if ($idea->save()) {

					$_POST['IdeaTranslation']['idea_id'] = $idea->id;
					$translation->setAttributes($_POST['IdeaTranslation']);

					if ($translation->save()) {
						$time_updated = new TimeUpdated;
						$time_updated->idea($id);

						if($lang){
							$this->redirect(array('idea/edit', 'id' => $idea->id, 'lang'=> $lang));
						} else {
							$this->redirect(array('idea/edit', 'id' => $idea->id));
						}
					}
				}
			}

			$data['idea'] = $sqlbuilder->load_array("idea", $filter);
			
			//for sidebar purposes
			$user_id = Yii::app()->user->id;
			$filter['user_id'] = $user_id;
			unset($filter['lang']);
			$data['user'] = $sqlbuilder->load_array("user", $filter);
			$this->data = $data;
			//for idea form purposes
			$user = UserEdit::Model()->findByAttributes( array( 'id' => $user_id ) );

			$this->render('editidea', array( 'idea' => $idea, 'translation' => $translation, 'data' => $data, 'user' => $user ));
		}

	}

	public function actionTranslate($id) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );

		$match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));
		$criteria=new CDbCriteria();
		$criteria->addInCondition('type_id',array(1,2)); //members
		$hasPriviledges = IdeaMember::Model()->findByAttributes(array('match_id' => $match->id, 'idea_id' => $id), $criteria);

		if($idea && $hasPriviledges){

			$translation = new IdeaTranslation;

			if (isset($_POST['IdeaTranslation'])) {
				$_POST['IdeaTranslation']['idea_id'] = $id;

				$exists = IdeaTranslation::Model()->findByAttributes( array( 'idea_id' => $idea->id, 'language_id' => $_POST['IdeaTranslation']['language_id'], 'deleted' => 0 ) );
				if($exists){
					$language = $this->loadModel($exists->language_id, 'Language');
					$this->redirect(Yii::app()->createUrl("idea/editTranslation", array('id' => $id, "lang"=>$language->language_code)));
				}

				$translation->setAttributes($_POST['IdeaTranslation']);
				if ($translation->save()) {
					$time_updated = new TimeUpdated;
					$time_updated->idea($id);

					$this->redirect(array('edit', 'id' => $id));
				}
			}

			$this->render('createtranslation', array( 'idea' => $idea, 'translation' => $translation ));
		}		
	}

	public function actionEditTranslation($id, $lang) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );

		$match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));
		$criteria=new CDbCriteria();
		$criteria->addInCondition('type_id',array(1,2)); //members
		$hasPriviledges = IdeaMember::Model()->findByAttributes(array('match_id' => $match->id, 'idea_id' => $id), $criteria);

		if($idea && $hasPriviledges){

			$language = Language::Model()->findByAttributes( array( 'language_code' => $lang ) );
			$translation = IdeaTranslation::Model()->findByAttributes( array( 'idea_id' => $idea->id, 'language_id' => $language->id, 'deleted' => 0 ) );

			if (isset($_POST['IdeaTranslation'])) {
				$_POST['IdeaTranslation']['idea_id'] = $id;

				$exists = IdeaTranslation::Model()->findByAttributes( array( 'idea_id' => $idea->id, 'language_id' => $_POST['IdeaTranslation']['language_id'], 'deleted' => 0 ) );
				if($exists){
					$language = $this->loadModel($exists->language_id, 'Language');
					$this->redirect(Yii::app()->createUrl("idea/editTranslation", array('id' => $id, "lang"=>$language->language_code)));
				}

				$translation->setAttributes($_POST['IdeaTranslation']);
				if ($translation->save()) {
					$time_updated = new TimeUpdated;
					$time_updated->idea($id);

					$this->redirect(array('edit', 'id' => $id));
				}
			}

			$this->render('edittranslation', array( 'idea' => $idea, 'translation' => $translation ));
		}
	}

	public function actionDeleteTranslation($id, $lang) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );

		$match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));
		$criteria=new CDbCriteria();
		$criteria->addInCondition('type_id',array(1,2)); //members
		$hasPriviledges = IdeaMember::Model()->findByAttributes(array('match_id' => $match->id, 'idea_id' => $id), $criteria);

		if($idea && $hasPriviledges){

			$sql = "SELECT count(id) FROM idea_translation WHERE id = $id AND deleted = 0";
			$numTranslations = Yii::app()->db->createCommand($sql)->queryScalar();
			if($numTranslations > 1){
				$language = Language::Model()->findByAttributes( array( 'language_code' => $lang ) );
				$translation = IdeaTranslation::Model()->findByAttributes( array( 'idea_id' => $idea->id, 'language_id' => $language->id, 'deleted' => 0 ) );

				$translation->setAttributes(array('deleted' => 1));

				if ($translation->save()) {
					$return['message'] = Yii::t('msg', "Success!");
					$return['status'] = 0;

					$time_updated = new TimeUpdated;
					$time_updated->idea($id);
				} else {
					$return['message'] = Yii::t('msg', "Oops! Something went wrong. Unable to remove translation from project.");
					$return['status'] = 1;
				}
				
				if(isset($_GET['ajax'])){
					$return = htmlspecialchars(json_encode($return), ENT_NOQUOTES);
					echo $return; //return array
					Yii::app()->end();
				}
			}
		}
	}

	public function actionDeleteIdea($id) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );
		
		$match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));
		$criteria=new CDbCriteria();
		$criteria->addInCondition('type_id',array(1)); //owner
		$hasPriviledges = IdeaMember::Model()->findByAttributes(array('match_id' => $match->id, 'idea_id' => $id), $criteria);

		if($idea && $hasPriviledges){
			$idea->setAttributes(array('deleted' => 1));
				
			if($idea->save()){
				$return['message'] = Yii::t('msg', "Success!");
				$return['status'] = 0;
			} else {
				$return['message'] = Yii::t('msg', "Oops! Something went wrong. Unable to delete project.");
				$return['status'] = 1;
			}
				
			if(isset($_GET['ajax'])){
				$return = htmlspecialchars(json_encode($return), ENT_NOQUOTES);
				echo $return; //return array
				Yii::app()->end();
			} else {
	           	//not ajax stuff
			}
		}

		$this->redirect(array('index'));
	}

	public function actionAddMember($id) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );

		$match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));
		$criteria=new CDbCriteria();
		$criteria->addInCondition('type_id',array(1)); //owner
		$hasPriviledges = IdeaMember::Model()->findByAttributes(array('match_id' => $match->id, 'idea_id' => $id), $criteria);

		if($idea && $hasPriviledges){

			$member = new IdeaMember;

			if (isset($_POST['IdeaMember'])) {

				$_POST['IdeaMember']['idea_id'] = $id;

				$match = UserMatch::Model()->findByAttributes( array( 'user_id' => $_POST['IdeaMember']['user_id'] ) );
				$_POST['IdeaMember']['idea_id'] = $id;
				$_POST['IdeaMember']['match_id'] = $match->id;
				$_POST['IdeaMember']['type_id'] = '2'; //HARDCODED MEMBER

				$exists = IdeaMember::Model()->findByAttributes( array( 'match_id' => $match->id, 'idea_id' => $id ) );
				if(!$exists){

					$member->setAttributes($_POST['IdeaMember']);

					if ($member->save()) {
						$return['message'] = Yii::t('msg', "Success!");
						$return['status'] = 0;

						$time_updated = new TimeUpdated;
						$time_updated->idea($id);
					} else {
						$return['message'] = Yii::t('msg', "Oops! Something went wrong. Unable to add new member to project.");
						$return['status'] = 1;
					}
					
					if(isset($_GET['ajax'])){
						$return = htmlspecialchars(json_encode($return), ENT_NOQUOTES);
						echo $return; //return array
						Yii::app()->end();
					} else {
		            	//not ajax stuff
					}
					
				}
			}
		}
	}

	public function actionDeleteMember($id, $user_id) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );

		$match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));
		$criteria=new CDbCriteria();
		$criteria->addInCondition('type_id',array(1)); //owner
		$hasPriviledges = IdeaMember::Model()->findByAttributes(array('match_id' => $match->id, 'idea_id' => $id), $criteria);

		if($idea && $hasPriviledges){
			$match = UserMatch::Model()->findByAttributes(array('user_id' => $user_id));
			$member = IdeaMember::Model()->findByAttributes( array( 'match_id' => $match->id ) );

			if($member->delete()){
				$return['message'] = Yii::t('msg', "Success!");
				$return['status'] = 0;

				$time_updated = new TimeUpdated;
				$time_updated->idea($id);
			} else {
				$return['message'] = Yii::t('msg', "Oops! Something went wrong. Unable to remove member from project.");
				$return['status'] = 1;
			}
			
			if(isset($_GET['ajax'])){
				$return = htmlspecialchars(json_encode($return), ENT_NOQUOTES);
				echo $return; //return array
				Yii::app()->end();
			} else {
	           	//not ajax stuff
			}
		}
	}

	public function actionAddCandidate($id) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );

		$match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));
		$criteria=new CDbCriteria();
		$criteria->addInCondition('type_id',array(1)); //owner
		$hasPriviledges = IdeaMember::Model()->findByAttributes(array('match_id' => $match->id, 'idea_id' => $id), $criteria);

		if($idea && $hasPriviledges){

			$candidate = new IdeaMember;
			$match = new UserMatch;

			if (isset($_POST['UserMatch'])) {
				$match->setAttributes($_POST['UserMatch']);

				if ($match->save()) {

					$_POST['IdeaMember']['idea_id'] = $id;
					$_POST['IdeaMember']['match_id'] = $match->id;
					$_POST['IdeaMember']['type_id'] = 3; //HARDCODED CANDIDATE
					$candidate->setAttributes($_POST['IdeaMember']);

					if($candidate->save()){
						$return['message'] = Yii::t('msg', "Success!");
						$return['status'] = 0;

						$time_updated = new TimeUpdated;
						$time_updated->idea($id);
					} else {
						$return['message'] = Yii::t('msg', "Oops! Something went wrong. Unable to add new candidate to project.");
						$return['status'] = 1;
					}
					
					if(isset($_GET['ajax'])){
						$return = htmlspecialchars(json_encode($return), ENT_NOQUOTES);
						echo $return; //return array
						Yii::app()->end();
					} else {
		            	//not ajax stuff
					}
				}
			}
		}
	}

	public function actionDeleteCandidate($id, $match_id) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );

		$match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));
		$criteria=new CDbCriteria();
		$criteria->addInCondition('type_id',array(1)); //owner
		$hasPriviledges = IdeaMember::Model()->findByAttributes(array('match_id' => $match->id, 'idea_id' => $id), $criteria);

		if($idea && $hasPriviledges){

			$match = UserMatch::Model()->findByAttributes( array( 'id' => $match_id ) );
			$candidate = IdeaMember::Model()->findByAttributes( array( 'match_id' => $match_id ) );
			$allgood = false;

			if($match->delete())
				$allgood = true;
			if($candidate->delete())
				$allgood = true;

			if($allgood){
				$return['message'] = Yii::t('msg', "Success!");
				$return['status'] = 0;

				$time_updated = new TimeUpdated;
				$time_updated->idea($id);
			} else {
				$return['message'] = Yii::t('msg', "Oops! Something went wrong. Unable to remove candidate from project.");
				$return['status'] = 1;
			}
				
			if(isset($_GET['ajax'])){
				$return = htmlspecialchars(json_encode($return), ENT_NOQUOTES);
				echo $return; //return array
				Yii::app()->end();
			} else {
	           	//not ajax stuff
			}
		}
	}

	public function actionAddCollabpref($id, $match_id) {

		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );

		$match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));
		$criteria=new CDbCriteria();
		$criteria->addInCondition('type_id',array(1)); //owner
		$hasPriviledges = IdeaMember::Model()->findByAttributes(array('match_id' => $match->id, 'idea_id' => $id), $criteria);

		if($idea && $hasPriviledges){

			$collabpref = new UserCollabpref;

			if (isset($_POST['UserCollabpref'])) {

				$_POST['UserCollabpref']['match_id'] = $match_id;

				$exists = UserCollabpref::Model()->findByAttributes( array( 'match_id' => $match_id, 'collab_id' => $_POST['UserCollabpref']['collab_id'] ) );
				if(!$exists){

					$collabpref->setAttributes($_POST['UserCollabpref']);

					if($collabpref->save()){
						$return['message'] = Yii::t('msg', "Success!");
						$return['status'] = 0;

						$time_updated = new TimeUpdated;
						$time_updated->idea($id);
					} else {
						$return['message'] = Yii::t('msg', "Oops! Something went wrong. Unable to update collaboration preferences.");
						$return['status'] = 1;
					}
						
					if(isset($_GET['ajax'])){
						$return = htmlspecialchars(json_encode($return), ENT_NOQUOTES);
						echo $return; //return array
						Yii::app()->end();
					} else {
			        	//not ajax stuff
					}
				}
			}
		}
	}

	public function actionDeleteCollabpref($id, $collab_id) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );

		$match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));
		$criteria=new CDbCriteria();
		$criteria->addInCondition('type_id',array(1)); //owner
		$hasPriviledges = IdeaMember::Model()->findByAttributes(array('match_id' => $match->id, 'idea_id' => $id), $criteria);

		if($idea && $hasPriviledges){

			$collabpref = UserCollabpref::Model()->findByAttributes( array( 'id' => $collab_id ) );

			if($collabpref->delete()){
				$return['message'] = Yii::t('msg', "Success!");
				$return['status'] = 0;

				$time_updated = new TimeUpdated;
				$time_updated->idea($id);
			} else {
				$return['message'] = Yii::t('msg', "Oops! Something went wrong. Unable to update collaboration preferences.");
				$return['status'] = 1;
			}
						
			if(isset($_GET['ajax'])){
				$return = htmlspecialchars(json_encode($return), ENT_NOQUOTES);
				echo $return; //return array
				Yii::app()->end();
			} else {
		    	//not ajax stuff
			}
		}
	}

	public function actionAddSkill($id, $match_id) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );

		$match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));
		$criteria=new CDbCriteria();
		$criteria->addInCondition('type_id',array(1)); //owner
		$hasPriviledges = IdeaMember::Model()->findByAttributes(array('match_id' => $match->id, 'idea_id' => $id), $criteria);

		if($idea && $hasPriviledges){

			$skill = new UserSkill;

			if (isset($_POST['UserSkill'])) {

				$_POST['UserSkill']['match_id'] = $match_id;

				$exists = UserSkill::Model()->findByAttributes( array( 'match_id' => $match_id, 'skill_id' => $_POST['UserSkill']['skill_id'], 'skillset_id' => $_POST['UserSkill']['skillset_id'] ) );
				if(!$exists){

					$skill->setAttributes($_POST['UserSkill']);

					if($skill->save()){
						$return['message'] = Yii::t('msg', "Success!");
						$return['status'] = 0;

						$time_updated = new TimeUpdated;
						$time_updated->idea($id);
					} else {
						$return['message'] = Yii::t('msg', "Oops! Something went wrong. Unable to update skills.");
						$return['status'] = 1;
					}
								
					if(isset($_GET['ajax'])){
						$return = htmlspecialchars(json_encode($return), ENT_NOQUOTES);
						echo $return; //return array
						Yii::app()->end();
					} else {
				    	//not ajax stuff
					}
				}
			}
		}
	}

	public function actionDeleteSkill($id, $skill_id) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );

		$match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));
		$criteria=new CDbCriteria();
		$criteria->addInCondition('type_id',array(1)); //owner
		$hasPriviledges = IdeaMember::Model()->findByAttributes(array('match_id' => $match->id, 'idea_id' => $id), $criteria);

		if($idea && $hasPriviledges){

			$skill = UserSkill::Model()->findByAttributes( array( 'id' => $skill_id ) );

			if($skill->delete()){
				$return['message'] = Yii::t('msg', "Success!");
				$return['status'] = 0;

				$time_updated = new TimeUpdated;
				$time_updated->idea($id);
			} else {
				$return['message'] = Yii::t('msg', "Oops! Something went wrong. Unable to update skills.");
				$return['status'] = 1;
			}
						
			if(isset($_GET['ajax'])){
				$return = htmlspecialchars(json_encode($return), ENT_NOQUOTES);
				echo $return; //return array
				Yii::app()->end();
			} else {
		    	//not ajax stuff
			}
		}
	}

	//AJAX
	public function actionRecent($id = 1) {

		$filter = Yii::app()->request->getQuery('filter', array());
		$filter['page'] = $id;
		
		//$filter['page'] = 1; // !!! remove
		
		$sqlbuilder = new SqlBuilder;
		$ideas = $sqlbuilder->load_array("recent_idea", $filter);
		$pagedata = $sqlbuilder->load_array("count_idea", $filter);

		$maxPage = floor($pagedata['num_of_rows'] / $pagedata['filter']['per_page']);

		//$maxPage = 3;

		if(isset($_GET['ajax'])){
			$return['data'] = $this->renderPartial('_recent', array("ideas" => $ideas, 'page' => $id, 'maxPage' => $maxPage));
			$return['message'] = Yii::t('msg', "Success!");
			$return['status'] = 0;
			$return = htmlspecialchars(json_encode($return), ENT_NOQUOTES);
			echo $return; //return array
			Yii::app()->end();
		} else {
			$this->render('recent', array('ideas' => $ideas, 'page' => $id, 'maxPage' => $maxPage));
		}
		
	}

}