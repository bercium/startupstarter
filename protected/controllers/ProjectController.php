<?php

class ProjectController extends GxController {

//	public $data = array();
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
		        'actions'=>array('create','edit','leaveIdea','deleteIdea'),
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
		$this->layout = "//layouts/none";
    
		$sqlbuilder = new SqlBuilder;
		$filter['idea_id'] =  $id;
		if($lang){
			$filter['lang'] = $lang;
		}

		$data['idea'] = $sqlbuilder->load_array("idea", $filter);

		if(!isset($data['idea']['id'])){
			throw new CHttpException(400, Yii::t('msg', "Oops! This project does not exist."));
		}

		//log clicks
		$click = new Click;
		$click->idea($id, Yii::app()->user->id);

		$this->render('view', array('data' => $data));
	}

	public function actionCreate($step = NULL){
		$this->ideaModify($step);
	}

	public function actionEdit($id, $lang = NULL){ //can take different languages to edit
		$this->ideaModify(NULL, $id, $lang);
	}

	public function ideaModify($step = NULL, $id = NULL, $lang = NULL){

		//general layout
		$this->layout="//layouts/edit";

		//for sidebar purposes
		$sqlbuilder = new SqlBuilder;
		$user_id = Yii::app()->user->id;
		$filter['user_id'] = $user_id;
		unset($filter['lang']);
		$data['user'] = $sqlbuilder->load_array("user", $filter);

		//safety resets
		if(!$id){
			if($step == NULL){
				$this->sessionReset('idea');
				$this->sessionReset('candidate');
				$this->redirect(array('project/create', 'step' => 1));
			}
			if($step != 1){
				if(!isset($_SESSION['IdeaCreated']))
					$this->redirect(array('project/create', 'step' => 1));
			}
		}
		if($id && isset($_SESSION['IdeaCreated']) && $id != $_SESSION['IdeaCreated']){
			$this->sessionReset('idea');
			$this->sessionReset('candidate');
			$_SESSION['IdeaCreated'] = $id;

			if($lang){
				$this->redirect(array('project/edit', 'id' => $id, 'lang' => $lang));
			} else {
				$this->redirect(array('project/edit', 'id' => $id));
			}
		}
		if($id && !isset($_SESSION['IdeaCreated'])){
			$_SESSION['IdeaCreated'] = $id;
		}

		//insert/edit priviledges
		$hasPriviledges = true;
		if($id){
			$match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));
			$criteria=new CDbCriteria();
			$criteria->addInCondition('type_id',array(1, 2)); //owner
			$hasPriviledges = IdeaMember::Model()->findByAttributes(array('match_id' => $match->id, 'idea_id' => $id), $criteria);
			if($hasPriviledges)
				$_SESSION['IdeaCreated'] = $id;
		}

		//set default language
		if($lang == NULL){
			$language = Language::Model()->findByAttributes( array( 'language_code' => Yii::app()->language ) );
		} else {
			$language = Language::Model()->findByAttributes( array( 'language_code' => $lang ) );
		}
		$language_id = $language->id;

		if($hasPriviledges){
		if($step == 1 || $id){

			//Idea is not created yet
			if(!isset($_SESSION['IdeaCreated'])){
				
				//prepare data objects
				$idea = new Idea;
				$translation = new IdeaTranslation;
				$member = new IdeaMember;

				//idea owner objects
				$user_id = Yii::app()->user->id;
				$match = UserMatch::Model()->findByAttributes( array( 'user_id' => $user_id ) );

				if (isset($_POST['Idea']) AND isset($_POST['IdeaTranslation'])) {
					$_POST['Idea']['time_updated'] = date("Y-m-d h:m:s",time());
					$idea->setAttributes($_POST['Idea']);

					if(!$idea->validate())
						Yii::app()->user->setFlash('profileMessageError', Yii::t('msg',"Unable to save project."));

					if ($idea->save()) {

						//translation data
						$translation->idea_id = $idea->id;
		 				$translation->setAttributes($_POST['IdeaTranslation']);

		 				//break up keywords and save
		 				$this->addKeywords($idea->id, $translation->language_id, $_POST['IdeaTranslation']['keywords']);

		 				//idea member data
		 				$_POST['IdeaMember']['idea_id'] = $idea->id;
		 				$_POST['IdeaMember']['match_id'] = $match->id;
		 				$_POST['IdeaMember']['type_id'] = 1;
						$member->setAttributes($_POST['IdeaMember']);

						//validate models
						if(!$member->validate())
							Yii::app()->user->setFlash('profileMessageError', Yii::t('msg',"Unable to assign administrator to project."));
						if(!$translation->validate())
							Yii::app()->user->setFlash('profileMessageError', Yii::t('msg',"Unable to save project details."));

						if ($translation->save() && $member->save()){
							//set session and go to step 2
							$_SESSION['IdeaCreated'] = $idea->id;

							Yii::app()->user->setFlash('profileMessageError', Yii::t('msg',"Project successfully saved."));

							//redirect
							if(!$id)
								$this->redirect(array('project/create', 'step' => 2));
						}
					}
				}

			} else {

				$idea_id = $_SESSION['IdeaCreated'];
				$idea = Idea::Model()->findByAttributes( array( 'id' => $idea_id, 'deleted' => 0 ) );

				if($idea){

					$translation = IdeaTranslation::Model()->findByAttributes( array( 'idea_id' => $idea->id, 'language_id' => $language_id, 'deleted' => 0 ) );
					if($translation == NULL)
						$translation = IdeaTranslation::Model()->findByAttributes( array( 'idea_id' => $idea->id, 'deleted' => 0 ) );

					if (isset($_POST['Idea']) AND isset($_POST['IdeaTranslation'])) {
						$_POST['time_updated'] = time();
						$idea->setAttributes($_POST['Idea']);

						if(!$idea->validate())
							Yii::app()->user->setFlash('profileMessageError', Yii::t('msg',"Unable to save project."));

						if ($idea->save()) {

							//translation data
							$_POST['IdeaTranslation']['idea_id'] = $idea->id;
							if($id)
								$_POST['IdeaTranslation']['language_id'] = $translation->language_id;
							$translation->setAttributes($_POST['IdeaTranslation']);

							//break up keywords and save
		 					$this->addKeywords($idea->id, $translation->language_id, $_POST['IdeaTranslation']['keywords']);

							if(!$translation->validate())
								Yii::app()->user->setFlash('profileMessageError', Yii::t('msg',"Unable to save project details."));

							if ($translation->save()) {
								$time_updated = new TimeUpdated;
								$time_updated->idea($idea->id);
								
								//redirect
								if($id){
									$this->redirect(array('project/edit', 'id' => $id, 'lang' => $lang));
								} else {
									$this->redirect(array('project/create', 'step' => 2));
								}
								
							}
						}
					}
				}
			}

			//render
			if(!$id)
				$this->render('createidea_1', array( 'idea' => $idea, 'translation' => $translation, 'language' => $language, 'ideas'=>$data['user']['idea'] ));
		}
		if($step == 2 || $id){

			//load idea data
			$idea_id = $_SESSION['IdeaCreated'];
			$filter['idea_id'] = $idea_id;
			if($lang)
				$filter['lang'] = $lang;
			$data['idea'] = $sqlbuilder->load_array("idea", $filter);

			//if an existing user is to be inserted as a member

			//if a new member is to be invited
			//!!!later

			//if candidate is to be created/edited
			$candidate_in_edit = false;
			//start new candidate session
			if( isset($_GET['candidate']) && $_GET['candidate'] == 'new' ){

				$this->sessionReset('candidate');
				$_SESSION['Candidate']['id'] = 'new';

				$candidate_in_edit = true;

				$match = new UserMatch();
				$collabprefs = new SqlBuilder;
				$collabprefs = $collabprefs->load_array('collabpref_empty');
				$_SESSION['Candidate']['collabpref'] = $collabprefs;
			}

			//end candidate session if not open
			if(!isset($_GET['candidate']))
				$this->sessionReset('candidate');

			//new candidate session is open
			if( isset($_GET['candidate']) && strlen($_GET['candidate']) == 0 ){
				//just in case
				if( !isset($_SESSION['Candidate']['id']) || !$_SESSION['Candidate']['id'] == 'new'){

					$this->sessionReset('candidate');
					$_SESSION['Candidate']['id'] = 'new';
					$collabprefs = new SqlBuilder;
					$collabprefs = $collabprefs->load_array('collabpref_empty');
					$_SESSION['Candidate']['collabpref'] = $collabprefs;
				}

				$candidate_in_edit = true;
				$match = new UserMatch();
			}

			//existent candidate session
			if( isset($_GET['candidate']) && ($_GET['candidate'] != 'new' && $_GET['candidate'] != '' && is_numeric($_GET['candidate']))){
				//load up session array if it doesn't exist yet
				if( !isset($_SESSION['Candidate']['id']) || $_SESSION['Candidate']['id'] != $_GET['candidate']){

					$this->sessionReset('candidate');
					$_SESSION['Candidate']['id'] = $_GET['candidate'];

					//load collabprefs
					$collabprefs = new SqlBuilder();
					$filter['match_id'] = $_SESSION['Candidate']['id'];
					$collabprefs = $collabprefs->load_array('collabpref', $filter);
					$_SESSION['Candidate']['collabpref'] = $collabprefs;

					//load skills
					if(isset($data['idea']['candidate'][$_GET['candidate']]['skillset']) && count($data['idea']['candidate'][$_GET['candidate']]['skillset']) > 0){
						foreach($data['idea']['candidate'][$_GET['candidate']]['skillset'] AS $key => $skillset){
							foreach($skillset['skill'] AS $key1 => $skill)
							$_SESSION['Candidate']['skills'][$key]['skillset_id'] = $skillset['id']; //id
							$_SESSION['Candidate']['skills'][$key]['skillset_name'] = $skillset['skillset'];  //id$skillset->name
							$_SESSION['Candidate']['skills'][$key]['skill'] = $skill['skill']; //skill name
						}
					}
				}

				$candidate_in_edit = true;
				$match = UserMatch::Model()->findByAttributes(array('id' => $_GET['candidate']));
			}

			//assign changes to currently edited candidate
			if(isset($_GET['candidate']) && isset($_POST['UserMatch']) && isset($_POST['CollabPref']) && $candidate_in_edit){
				//assign changes ($_POST) to session array 
				$match->setAttributes($_POST['UserMatch']);

				//save user match and delete collabprefs
				//difference between existing and new candidate
				$match_saved = false;
				if( isset($_GET['candidate']) && ($_GET['candidate'] != 'new' && $_GET['candidate'] != '' && is_numeric($_GET['candidate']))){
					$match_id = $_SESSION['Candidate']['id'];				
					UserCollabpref::Model()->deleteAll("match_id = :match_id", array(':match_id' => $match_id));
					UserSkill::Model()->deleteAll("match_id = :match_id", array(':match_id' => $match_id));
					
					if($match->save())
						$match_saved = true;
				} else {
					if($match->save()){
						$match_saved = true;
						$match_id = $match->id;
					}
				}

				//save idea_member
				$ideamember_saved = false;
				if($match_saved){
					$ideaMember = new IdeaMember;
					$ideaMember->idea_id = $idea_id;
					$ideaMember->match_id = $match_id;
					$ideaMember->type_id = 3;
					if($ideaMember->save())
						$ideamember_saved = true;
				}

				//collabprefs
				$c = count($_POST['CollabPref']);
				foreach ($_POST['CollabPref'] as $collab => $collab_name){
					$user_collabpref = new UserCollabpref;
					$user_collabpref->match_id = $match_id;
					$user_collabpref->collab_id = $collab;
					if ($user_collabpref->save()) $c--;
				}

				//skills
				$s = 0;
				if(isset($_SESSION['Candidate']['skills'])){
					$s = count($_SESSION['Candidate']['skills']);
					foreach($_SESSION['Candidate']['skills'] AS $key => $value){

				        $skill = Skill::model()->findByAttributes(array("name"=>$value['skill']));
				        // save new skill
				        if ($skill == null){
				          $skill = new Skill;
				          $skill->name = $value['skill'];
				          $skill->save();
				        }
				        
				        if ($skill->id){
				          $skillset_skill = SkillsetSkill::model()->findByAttributes(array("skill_id"=>$skill->id,
				                                                                           "skillset_id"=>$value['skillset_id']));
				          // save skillset skill connection
				          $usage_count = false;
					      if ($skillset_skill == null){
					        $skillset_skill = new SkillsetSkill;
					        $skillset_skill->skill_id = $skill->id;
					        $skillset_skill->skillset_id = $value['skillset_id'];
					        $skillset_skill->usage_count = 1;
					        $skillset_skill->save();
					      } else {
					      	$usage_count = true;
					      }
				          
					        $user_skill = UserSkill::model()->findByAttributes(array("skill_id"=>$skill->id,
					                                                                 "skillset_id"=>$value['skillset_id'],
					                                                                 "match_id"=>$match_id,));
				          	if ($user_skill == null){
					            $user_skill = new UserSkill;
					            $user_skill->skill_id = $skill->id;
					            $user_skill->skillset_id = $value['skillset_id'];
					            $user_skill->match_id = $match_id;
					            $user_skill->save();

					            if($usage_count){
									$skillset_skill->usage_count = $skillset_skill->usage_count + 1;
									$skillset_skill->save();
					            }
				          	}
					   	}
					}
				}
				
				//check if it went okay
				if ($c == 0 && $s == 0 && $match_saved && $ideamember_saved) {
					Yii::app()->user->setFlash('profileMessage', Yii::t('msg',"Profile details saved."));
					//reset session
					$candidate_in_edit = false;
					$this->sessionReset('candidate');
				}else{
					Yii::app()->user->setFlash('profileMessageError', Yii::t('msg',"Unable to save profile details."));
				}

				if($id){
					$this->redirect(array('project/edit', 'id' => $id, 'lang' => $lang));
				} else {
					$this->redirect(array('project/create', 'step' => 2));
				}
			}

			//delete candidate
			if(isset($_GET['delete_candidate']) && is_numeric($_GET['delete_candidate']) && $_GET['delete_candidate'] > 0){
				UserCollabpref::Model()->deleteAll("match_id = :match_id", array(':match_id' => $_GET['delete_candidate']));
				UserSkill::Model()->deleteAll("match_id = :match_id", array(':match_id' => $_GET['delete_candidate']));
				IdeaMember::Model()->deleteAll("match_id = :match_id", array(':match_id' => $_GET['delete_candidate']));
				UserMatch::Model()->deleteAll("id = :match_id", array(':match_id' => $_GET['delete_candidate']));
				

				Yii::app()->user->setFlash('profileMessageError', Yii::t('msg',"Open position deleted."));

				if($id){
					$this->redirect(array('project/edit', 'id' => $id, 'lang' => $lang));
				} else {
					$this->redirect(array('project/create', 'step' => 2));
				}
			}

			//render
			if(!$id){
				if(isset($_SESSION['Candidate']) && $candidate_in_edit){
					$this->render('createidea_2', array( 'ideadata' => $data['idea'], 'idea_id' => $idea_id, 'candidate' => $_SESSION['Candidate'], 'match' => $match ));
				} else {
					$this->render('createidea_2', array( 'ideadata' => $data['idea'], 'idea_id' => $idea_id ));
				}
			}
		}
		if($step == 3 || $id) {
			$idea_id = $_SESSION['IdeaCreated'];
			
			$translation = IdeaTranslation::Model()->findByAttributes( array( 'idea_id' => $idea->id, 'language_id' => $language_id, 'deleted' => 0 ) );
			if($translation == NULL)
				$translation = IdeaTranslation::Model()->findByAttributes( array( 'idea_id' => $idea->id, 'deleted' => 0 ) );

			if(!$id)
				$this->render('createidea_3', array('translation' => $translation, 'idea_id' => $idea_id));
		}

		//render for edit
		if($id){

			$data_array['id'] = $id;
			$data_array['lang'] = $lang;
			$data_array['isOwner']=($hasPriviledges->type_id==1);

			if(isset($idea))
				$data_array['idea'] = $idea;

			if(isset($data['idea']))
				$data_array['ideadata'] = $data['idea'];

			if(isset($idea_id))
				$data_array['idea_id'] = $idea_id;

			if(isset($translation))
				$data_array['translation'] = $translation;

			if(isset($language))
				$data_array['language'] = $language;

			if(isset($data['user']['idea']))
				$data_array['ideas'] = $data['user']['idea'];

			if(isset($_SESSION['Candidate']))
				$data_array['candidate'] = $_SESSION['Candidate'];

			if(isset($match))
				$data_array['match'] = $match;

			$this->render('editidea', $data_array);
		}
		}
	}

	public function addKeywords($idea_id, $language_id, $keywords){
		Keyword::Model()->deleteAll("keyword.table = :table AND row_id = :row_id", array(':table' => 'idea_translation', ':row_id' => $idea_id));

		$keyworder = new Keyworder;
		$keywords = $keyworder->string2array($keywords);

		foreach($keywords AS $key => $word){
          $keyword = new Keyword;
          $keyword->table = 'idea_translation';
          $keyword->row_id = $idea_id;
          $keyword->keyword = $word;
          $keyword->language_id = $language_id;
          $keyword->save();
		}
	}

	public function actionTranslate($id) {

		//general layout
		$this->layout="//layouts/edit";

		//for sidebar purposes
		$sqlbuilder = new SqlBuilder;
		$user_id = Yii::app()->user->id;
		$filter['user_id'] = $user_id;
		unset($filter['lang']);
		$data['user'] = $sqlbuilder->load_array("user", $filter);

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
					$this->redirect(Yii::app()->createUrl("project/edit", array('id' => $id, "lang"=>$language->language_code)));
				}

				$translation->setAttributes($_POST['IdeaTranslation']);
				if ($translation->save()) {
					$time_updated = new TimeUpdated;
					$time_updated->idea($id);

					//break up keywords and save
		 			$this->addKeywords($id, $translation->language_id, $_POST['IdeaTranslation']['keywords']);

		 			$language = Language::Model()->findByAttributes(array('id' => $translation->language_id));

					$this->redirect(array('edit', 'id' => $id, 'lang' => $language->language_code));
				}
			}

			$this->render('createtranslation', array( 'idea' => $idea, 'translation' => $translation ));
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

    	$ideaMember = IdeaMember::Model()->findByAttributes(array('type_id' => 1,'match_id' => $match->id, 'idea_id' => $id));
		if($idea && $ideaMember){
			$idea->deleted = 1;
				
			if($idea->save()){
        Yii::app()->user->setFlash('removeProjectsMessage', Yii::t('msg',"Project successfully removed."));
			}
		}

    	$this->redirect(Yii::app()->createUrl('profile/projects'));
	}
  
	 public function actionLeaveIdea($id){
		$match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));

	    $ideaMember = IdeaMember::Model()->findByAttributes(array('type_id' => 2,'match_id' => $match->id, 'idea_id' => $id));
	    if($ideaMember){
	      $ideaMember->delete();
        Yii::app()->user->setFlash('removeProjectsMessage', Yii::t('msg',"You are no longer member of a project."));
	    }
	    $this->redirect(Yii::app()->createUrl('profile/projects'));
	  }

	//ajax functions
	public function actionSAddSkill() {

		//check for permission
		$user_id = Yii::app()->user->id;

		//status
		$status = 1;

		if(isset($_SESSION['Candidate']['id']) && $user_id > 0){

			if (!empty($_POST['skill']) && !empty($_POST['skillset'])) {

				$skillset = Skillset::model()->findByPk($_POST['skillset']);
				if($skillset){
					$key = $_POST['skillset'] . "_" . $_POST['skill'];

					$_SESSION['Candidate']['skills'][$key]['skillset_id'] = $_POST['skillset']; //id
					$_SESSION['Candidate']['skills'][$key]['skillset_name'] = $skillset->name; //id$skillset->name
					$_SESSION['Candidate']['skills'][$key]['skill'] = $_POST['skill']; //skill name

					$status = 0;
				} else {
					$status = 1;
				}
			}

		}

		if($status == 0){
			$response = array("data" => array("title" => $_POST['skill'],
			                                "id" => $key,
			                                "location" => Yii::app()->createUrl("project/sDeleteSkill"),
			                                "desc" => $skillset->name, // !!! add description
			                ),
			"status" => 0,
			"message" => "");
		} else {
			$response = array("data" => null,
							"status" => 1,
							"message" => Yii::t('msg', "Problem saving skill. Please check fields for correct values."));
		}
    	echo json_encode($response);
    	Yii::app()->end();
       
	}

	public function actionSDeleteSkill() {
    
		if (isset($_SESSION['Candidate']['skills'][$_POST['id']])){
			unset($_SESSION['Candidate']['skills'][$_POST['id']]);
			$return['message'] = '';
			$return['status'] = 0;
		} else {
			$return['message'] = Yii::t('msg', "Unable to remove skill.");
			$return['status'] = 1;
		}

		if (isset($_GET['ajax'])) {
			$return = json_encode($return);
			echo $return; //return array
			Yii::app()->end();
		} else {
			//not ajax stuff
		}
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

    if(isset($_GET['ajax'])) $filter['per_page'] = 3;
    else $filter['per_page'] = 9;
		
		$sqlbuilder = new SqlBuilder;
		$ideas = $sqlbuilder->load_array("recent_updated", $filter);
		$pagedata = $sqlbuilder->load_array("count_idea", $filter);

		$maxPage = ceil($pagedata['num_of_rows'] / $pagedata['filter']['per_page']);

		if(isset($_GET['ajax'])){
			$return['data'] = $this->renderPartial('_recent', array("ideas" => $ideas, 'page' => $id, 'maxPage' => $maxPage),true);
			$return['message'] = '';
			$return['status'] = 0;
			$return = json_encode($return);
			echo $return; //return array
			Yii::app()->end();
		} else {
			$this->render('recent', array('ideas' => $ideas, 'page' => $id, 'maxPage' => $maxPage));
		}
		
	}

	public function sessionReset($type){

		if($type == 'candidate'){
			if(isset($_SESSION['Candidate']['collabprefs'])){
				foreach($_SESSION['Candidate']['collabprefs'] as $key => $value){
					unset($_SESSION['Candidate']['collabprefs'][$key]);
				}
				unset($_SESSION['Candidate']['collabprefs']);
			}
			if(isset($_SESSION['Candidate']['skills'])){
				foreach($_SESSION['Candidate']['skills'] as $key => $value){
					unset($_SESSION['Candidate']['skills'][$key]);
				}
				unset($_SESSION['Candidate']['skills']);
			}
			if(isset($_SESSION['Candidate']['id'])){
				unset($_SESSION['Candidate']['id']);
			}
			if(isset($_SESSION['Candidate'])){
				unset($_SESSION['Candidate']);
			}		
			
		} elseif($type == 'idea'){
			unset($_SESSION['IdeaCreated']);
		}
	}

}
