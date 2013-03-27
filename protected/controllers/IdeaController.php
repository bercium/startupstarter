<?php

class IdeaController extends GxController {


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
			array('allow', // allow admins only
				'users'=>Yii::app()->getModule('user')->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	/*
  IdeaController (idea page)
	Index  (display page)
		Input (get)
			! idea_id
			language_code (read from user config otherwise)
		Output
			idea(A)
			members(A)
			candidates(A)

	Contact (contact page)
		Input (get)
			! idea_id
		Input (post)
			subject
			message
		Output
			(form) || redirect->Index/idea_id

	Edit (edit idea page)
		Input (get)
			! idea_id
			language_code
		Input (post)
			idea(A)
			translation(A)
		Output
			idea(A)(form)
			members(A)
			candidates(A)

	Translate (add a new translation to the idea page)
		Input (get)
			! idea_id
			! language_code
		Input (post)
			translation
		Output
			translation(A)(form) || redirect->Edit/idea_id,language_code

	AddCandidate (add a new candidate action)
		Input (get)
			! idea_id
		Input (post)
			skillsets(A),skills(A)
			collabprefs(A)
			time_per_week
			country_id
			location_id
		Output
			form || redirect->Edit/idea_id

	AddSkill
		Input (get)
			idea_id
			user_id
			skill(A)
		Output
			redirect->Edit/idea_id

	RemoveSkill
		Input (get)
			idea_id
			user_id
			skill_id
		Output
			redirect->Edit/idea_id

	AddCollabpref
		Input (get)
			idea_id
		Input (post)
			user_id
			collabpref_id(A)
		Output
			redirect->Edit/idea_id

	RemoveCollabpref
		Input (get)
			idea_id
		Input (post)
			user_id
			collabpref_id(A)
		Output
			redirect->Edit/idea_id

	AddMember (add a new member to the team action)
		Input (get)
			! idea_id
			! user_id
		Output
			redirect->Edit/idea_id

	RemoveMember (remove a member from a team action)
		Input (get)
			! idea_id
			! user_id
			redirect
		Output
			redirect->Edit/idea_id

	Create (create a new idea page)
		Input (post)
			idea(A)
			translation(A)
		Output
			(form) || redirect->Edit/idea_id
			*/

	public function actionIndex() { //create new idea
		echo 'Links: <br/><br/>
		/ -> create new idea <br/>
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
		<br/>';

		$idea = new Idea;
		$translation = new IdeaTranslation;

		if (isset($_POST['Idea']) AND isset($_POST['IdeaTranslation'])) {
			$idea->setAttributes($_POST['Idea']);

			if ($idea->save()) {

				$_POST['IdeaTranslation']['idea_id'] = $idea->id;
				$translation->setAttributes($_POST['IdeaTranslation']);

				if ($translation->save()) {

					if (Yii::app()->getRequest()->getIsAjaxRequest())
						Yii::app()->end();
					else
						$this->redirect(array('view', 'id' => $idea->id));
				}
			}
		}

		$this->render('createidea', array( 'idea' => $idea, 'translation' => $translation ));
	}

	public function actionView($id, $lang = NULL) {
		$sqlbuilder = new SqlBuilder;
		$filter = array( 'idea_id' => $id);
		if($lang){
			$filter['lang'] = $lang;
		}

		$data_array['idea'] = $sqlbuilder->load_array("idea", $filter);

		$this->render('index', array('data_array' => $data_array));
	}

	public function actionEdit($id, $lang = NULL) { //can take different languages to edit
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );
		if($idea){

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
				$idea->setAttributes($_POST['Idea']);

				if ($idea->save()) {

					$_POST['IdeaTranslation']['idea_id'] = $idea->id;
					$translation->setAttributes($_POST['IdeaTranslation']);

					if ($translation->save()) {

						if (Yii::app()->getRequest()->getIsAjaxRequest())
							Yii::app()->end();
						else
							$this->redirect(array('view', 'id' => $idea->id));
					}
				}
			}

			$data_array['idea'] = $sqlbuilder->load_array("idea", $filter);

			$this->render('editidea', array( 'idea' => $idea, 'translation' => $translation, 'data_array' => $data_array ));
		} else {
			$this->redirect(array('index'));
		}

	}

	public function actionTranslate($id) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );
		if($idea){

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

					if (Yii::app()->getRequest()->getIsAjaxRequest())
						Yii::app()->end();
					else
						$this->redirect(array('edit', 'id' => $id));
				}
			}

			$this->render('createtranslation', array( 'idea' => $idea, 'translation' => $translation ));
		} else {
			$this->redirect(array('index'));
		}
		
	}

	public function actionEditTranslation($id, $lang) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );
		if($idea){

			$language = Language::Model()->findByAttributes( array( 'language_code' => $lang ) );
			$translation = IdeaTranslation::Model()->findByAttributes( array( 'idea_id' => $idea->id, 'language_id' => $language->id, 'deleted' => 0 ) );

			if (isset($_POST['IdeaTranslation'])) {
				$_POST['IdeaTranslation']['idea_id'] = $id;

				$translation->setAttributes($_POST['IdeaTranslation']);
				if ($translation->save()) {

					if (Yii::app()->getRequest()->getIsAjaxRequest())
						Yii::app()->end();
					else
						$this->redirect(array('edit', 'id' => $id));
				}
			}

			$this->render('edittranslation', array( 'idea' => $idea, 'translation' => $translation ));
		} else {
			$this->redirect(array('index'));
		}


	}

	public function actionDeleteTranslation($id, $lang) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );
		if($idea){

			$language = Language::Model()->findByAttributes( array( 'language_code' => $lang ) );
			$translation = IdeaTranslation::Model()->findByAttributes( array( 'idea_id' => $idea->id, 'language_id' => $language->id, 'deleted' => 0 ) );

			$translation->setAttributes(array('deleted' => 1));

			if ($translation->save()) {
				
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('edit', 'id' => $id));
			}

			$this->redirect(array('edit', 'id' => $id));
		} else {
			$this->redirect(array('index'));
		}

	}

	public function actionDeleteIdea($id) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );
		if($idea){
			$idea->setAttributes(array('deleted' => 1));

			if ($idea->save()) {
				
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('index'));
			}
		}

		$this->redirect(array('index'));
	}

	public function actionAddMember($id) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );
		if($idea){

			$member = new IdeaMember;

			if (isset($_POST['IdeaMember'])) {

				$_POST['IdeaMember']['idea_id'] = $id;

				$match = UserMatch::Model()->findByAttributes( array( 'user_id' => $_POST['IdeaMember']['match_id'] ) );
				$_POST['IdeaMember']['idea_id'] = $id;
				$_POST['IdeaMember']['match_id'] = $match->id;

				$exists = IdeaMember::Model()->findByAttributes( array( 'match_id' => $match->id, 'idea_id' => $id ) );
				if(!$exists){

					$member->setAttributes($_POST['IdeaMember']);

					if ($member->save()) {

						if (Yii::app()->getRequest()->getIsAjaxRequest())
							Yii::app()->end();
						else
							$this->redirect(array('edit', 'id' => $idea->id));
					}
				} else {
					$this->redirect(array('editMember', 'id' => $idea->id, 'member_id' => $exists->id ));
				}

			}

			$this->render('addMember', array( 'idea' => $idea, 'member' => $member ));
		} else {
			$this->redirect(array('index'));
		}
	}

	public function actionEditMember($id, $member_id) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );
		if($idea){

			$member = IdeaMember::Model()->findByAttributes( array( 'id' => $member_id ) );

			if (isset($_POST['IdeaMember'])) {

				$member->setAttributes($_POST['IdeaMember']);

				if ($member->save()) {
						
					if (Yii::app()->getRequest()->getIsAjaxRequest())
						Yii::app()->end();
					else
						$this->redirect(array('edit', 'id' => $idea->id));
					
				}
			}

			$this->render('editMember', array( 'idea' => $idea, 'member' => $member ));
		} else {
			$this->redirect(array('index'));
		}
	}

	public function actionDeleteMember($id, $member_id) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );
		if($idea){

			$member = IdeaMember::Model()->findByAttributes( array( 'id' => $member_id ) );

			$member->delete();

			if (Yii::app()->getRequest()->getIsAjaxRequest())
				Yii::app()->end();
			else
				$this->redirect(array('edit', 'id' => $idea->id));
		} else {
			$this->redirect(array('index'));
		}
	}

	public function actionAddCandidate($id) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );
		if($idea){

			$candidate = new IdeaMember;
			$match = new UserMatch;

			if (isset($_POST['UserMatch'])) {
				$match->setAttributes($_POST['UserMatch']);

				if ($match->save()) {

					$_POST['IdeaMember']['idea_id'] = $id;
					$_POST['IdeaMember']['match_id'] = $match->id;
					$_POST['IdeaMember']['type'] = 3;
					$candidate->setAttributes($_POST['IdeaMember']);

					if ($candidate->save()) {
						
						if (Yii::app()->getRequest()->getIsAjaxRequest())
							Yii::app()->end();
						else
							$this->redirect(array('edit', 'id' => $idea->id));
					}
				}
			}

			$this->render('addcandidate', array( 'idea' => $idea, 'match' => $match ));
		} else {
			$this->redirect(array('index'));
		}
	}

	public function actionEditCandidate($id, $candidate_id) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );
		if($idea){

			$match = UserMatch::Model()->findByAttributes( array( 'id' => $candidate_id ) );

			if (isset($_POST['UserMatch'])) {
				$match->setAttributes($_POST['UserMatch']);

				if ($match->save()) {
						
					if (Yii::app()->getRequest()->getIsAjaxRequest())
						Yii::app()->end();
					else
						$this->redirect(array('edit', 'id' => $idea->id));
					
				}
			}

			$this->render('editcandidate', array( 'idea' => $idea, 'match' => $match ));
		} else {
			$this->redirect(array('index'));
		}
	}

	public function actionDeleteCandidate($id, $candidate_id) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );
		if($idea){

			$match = UserMatch::Model()->findByAttributes( array( 'id' => $candidate_id ) );
			$candidate = IdeaMember::Model()->findByAttributes( array( 'match_id' => $candidate_id ) );

			$match->delete();
			$candidate->delete();

			if (Yii::app()->getRequest()->getIsAjaxRequest())
				Yii::app()->end();
			else
				$this->redirect(array('edit', 'id' => $idea->id));
		} else {
			$this->redirect(array('index'));
		}
	}

	public function actionAddCollabpref($id, $candidate_id) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );
		if($idea){

			$collabpref = new UserCollabpref;

			if (isset($_POST['UserCollabpref'])) {

				$_POST['UserCollabpref']['match_id'] = $candidate_id;

				$exists = UserCollabpref::Model()->findByAttributes( array( 'match_id' => $candidate_id, 'collab_id' => $_POST['UserCollabpref']['collab_id'] ) );
				if(!$exists){

					$collabpref->setAttributes($_POST['UserCollabpref']);

					if ($collabpref->save()) {

						if (Yii::app()->getRequest()->getIsAjaxRequest())
							Yii::app()->end();
						else
							$this->redirect(array('editCandidate', 'id' => $idea->id, 'candidate_id' => $candidate_id ));
					}
				} else {
					$this->redirect(array('editCandidate', 'id' => $idea->id, 'candidate_id' => $candidate_id ));
				}
			}

			$this->render('addcollabpref', array( 'idea' => $idea, 'collabpref' => $collabpref ));
		} else {
			$this->redirect(array('index'));
		}
	}

	public function actionDeleteCollabpref($id, $candidate_id, $collab_id) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );
		if($idea){

			$collabpref = UserCollabpref::Model()->findByAttributes( array( 'id' => $collab_id ) );

			$collabpref->delete();

			if (Yii::app()->getRequest()->getIsAjaxRequest())
				Yii::app()->end();
			else
				$this->redirect(array('editCandidate', 'id' => $idea->id, 'candidate_id' => $candidate_id ));
		} else {
			$this->redirect(array('index'));
		}
	}

	public function actionAddSkill($id, $candidate_id) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );
		if($idea){

			$skill = new UserSkill;

			if (isset($_POST['UserSkill'])) {

				$_POST['UserSkill']['match_id'] = $candidate_id;

				$exists = UserSkill::Model()->findByAttributes( array( 'match_id' => $candidate_id, 'skill_id' => $_POST['UserSkill']['skill_id'], 'skillset_id' => $_POST['UserSkill']['skillset_id'] ) );
				if(!$exists){

					$skill->setAttributes($_POST['UserSkill']);

					if ($skill->save()) {

						if (Yii::app()->getRequest()->getIsAjaxRequest())
							Yii::app()->end();
						else
							$this->redirect(array('editCandidate', 'id' => $idea->id, 'candidate_id' => $candidate_id ));
					}
				} else {
					$this->redirect(array('editCandidate', 'id' => $idea->id, 'candidate_id' => $candidate_id ));
				}
			}

			$this->render('addskill', array( 'idea' => $idea, 'skill' => $skill ));
		} else {
			$this->redirect(array('index'));
		}
	}

	public function actionDeleteSkill($id, $candidate_id, $skill_id) {
		$idea = Idea::Model()->findByAttributes( array( 'id' => $id, 'deleted' => 0 ) );
		if($idea){

			$skill = UserSkill::Model()->findByAttributes( array( 'id' => $skill_id ) );

			$skill->delete();

			if (Yii::app()->getRequest()->getIsAjaxRequest())
				Yii::app()->end();
			else
				$this->redirect(array('editCandidate', 'id' => $idea->id, 'candidate_id' => $candidate_id ));
		} else {
			$this->redirect(array('index'));
		}
	}

}