<?php

class ProfileController extends GxController {


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

	public function actionIndex() {
		echo 'Links: <br/><br/>
		/ -> edit user profile<br/>
		/$user_id -> edit user profile by id (admin only, duplicated actionIndex because of main.php urlmanager setup)<br/>
		/removeIdea/$idea_id&user_id=$user_id -> remove idea by id (additional admin user_id option) <br/>
		/addCollabpref/$user_id -> add collabpref (additional admin user_id option)<br/>
		/deleteCollabpref/$usercollab_id&user_id=$user_id -> delete collabpref by usercollab_id (additional admin user_id ($id) option)<br/>
		/addSkill/$user_id -> add skill (additional admin user_id option)<br/>
		/deleteSkill/$userskill_id&user_id=$user_id -> delete skill by userskill_id (additional admin user_id option)<br/>
		/addLink/$user_id -> add link (additional admin user_id option)<br/>
		/deleteLink/$link_id&user_id -> delete link by link_id (additional admin user_id option)<br/>
		<br/>';

		$user_id = Yii::app()->user->id;

		if($user_id > 0){

			$user = UserEdit::Model()->findByAttributes( array( 'id' => $user_id ) );
			if($user){

				$match = UserMatch::Model()->findByAttributes( array( 'user_id' => $user_id ) );
				
				if (isset($_POST['UserEdit']) AND isset($_POST['UserMatch'])) {
					$user->setAttributes($_POST['UserEdit']);

					if ($user->save()) {

						$_POST['UserMatch']['user_id'] = $user_id;
						$match->setAttributes($_POST['UserMatch']);

						if ($match->save()) {

							if (Yii::app()->getRequest()->getIsAjaxRequest())
								Yii::app()->end();
							else
									$this->redirect(array('profile/'));
						}
					}
				}

				$filter['user_id'] = $user_id;
				$sqlbuilder = new SqlBuilder;
				$data['user'] = $sqlbuilder->load_array("user", $filter);

				$this->render('index', array( 'user' => $user, 'match' => $match, 'data' => $data ));
			} else {
				//this would cause an infinite loop, so lets not do it
				//in a perfect world this would redirect to the register page. not sure how to dynamically redirect outside the same controller
				//$this->redirect(array('index'));
			}
		} else {
			//this would cause an infinite loop, so lets not do it
			//in a perfect world this would redirect to the register page. not sure how to dynamically redirect outside the same controller
			//$this->redirect(array('index'));
		}
	}

	public function actionView($id) { //only for admins

		//check for permission
		if(Yii::app()->user->id == $id || Yii::app()->user->superuser == 1){ //is this person, or is superuser
			$user_id = $id;
		}

		if($user_id){

			$user = UserEdit::Model()->findByAttributes( array( 'id' => $user_id ) );
			if($user){

				$match = UserMatch::Model()->findByAttributes( array( 'user_id' => $user_id ) );
				
				if (isset($_POST['UserEdit']) AND isset($_POST['UserMatch'])) {
					$user->setAttributes($_POST['UserEdit']);

					if ($user->save()) {

						$_POST['UserMatch']['user_id'] = $user_id;
						$match->setAttributes($_POST['UserMatch']);

						if ($match->save()) {

							if (Yii::app()->getRequest()->getIsAjaxRequest())
								Yii::app()->end();
							else
								$this->redirect(array('view', 'id' => $user_id ));
						}
					}
				}

				$filter['user_id'] = $user_id;
				$sqlbuilder = new SqlBuilder;
				$data['user'] = $sqlbuilder->load_array("user", $filter);

				$this->render('index', array( 'user' => $user, 'match' => $match, 'data' => $data ));
			} else {
				//this would cause an infinite loop, so lets not do it
				//in a perfect world this would redirect to the register page. not sure how to dynamically redirect outside the same controller
				//$this->redirect(array('index'));
			}
		} else {
			//this would cause an infinite loop, so lets not do it
			//in a perfect world this would redirect to the register page. not sure how to dynamically redirect outside the same controller
			//$this->redirect(array('index'));
		}
	}

	public function actionRemoveIdea($id, $idea_id) {

		$match = UserMatch::Model()->findByAttributes( array( 'id' => $id ) );

		//check for permission
		if( $match && ($match->user_id == Yii::app()->user->id || Yii::app()->user->superuser == 1 )){

			$member = IdeaMember::Model()->findByAttributes( array( 'idea_id' => $idea_id, 'match_id' => $match->id ) );
			$member->delete();

			if (Yii::app()->getRequest()->getIsAjaxRequest())
				Yii::app()->end();
			else
				$this->redirect(array('view', 'id' => $match->user_id ));

		} else {
			$this->redirect(array('profile/'));
		}

	}

	public function actionAddCollabpref($id) {

		$match = UserMatch::Model()->findByAttributes( array( 'id' => $id ) );

		//check for permission
		if( $match && ($match->user_id == Yii::app()->user->id || Yii::app()->user->superuser == 1 )){

			$collabpref = new UserCollabpref;

			if (isset($_POST['UserCollabpref'])) {

				$_POST['UserCollabpref']['match_id'] = $id;

				$exists = UserCollabpref::Model()->findByAttributes( array( 'match_id' => $id, 'collab_id' => $_POST['UserCollabpref']['collab_id'] ) );
				if(!$exists){

					$collabpref->setAttributes($_POST['UserCollabpref']);

					if ($collabpref->save()) {

						if (Yii::app()->getRequest()->getIsAjaxRequest())
							Yii::app()->end();
						else
							$this->redirect(array('view', 'id' => $match->user_id ));

					} else {
						$this->redirect(array('view', 'id' => $match->user_id ));
					}
				}

				$this->render('addcollabpref', array( 'collabpref' => $collabpref ));
			} else {
				$this->redirect(array('profile/'));
			}

		} else {
			$this->redirect(array('profile/'));
		}
	}

	public function actionDeleteCollabpref($id, $collab_id) {

		$match = UserMatch::Model()->findByAttributes( array( 'id' => $id ) );

		//check for permission
		if( $match && ($match->user_id == Yii::app()->user->id || Yii::app()->user->superuser == 1 )){

			$collabpref = UserCollabpref::Model()->findByAttributes( array( 'id' => $collab_id ) );
			$collabpref->delete();

			if (Yii::app()->getRequest()->getIsAjaxRequest())
				Yii::app()->end();
			else
				$this->redirect(array('view', 'id' => $match->user_id ));

		} else {
			$this->redirect(array('profile/'));
		}
	}

	public function actionAddSkill($id) {

		$match = UserMatch::Model()->findByAttributes( array( 'id' => $id ) );

		//check for permission
		if( $match && ($match->user_id == Yii::app()->user->id || Yii::app()->user->superuser == 1 )){

			$skill = new UserSkill;

			if (isset($_POST['UserSkill'])) {

				$_POST['UserSkill']['match_id'] = $id;
			
				$exists = UserSkill::Model()->findByAttributes( array( 'match_id' => $id, 'skill_id' => $_POST['UserSkill']['skill_id'], 'skillset_id' => $_POST['UserSkill']['skillset_id'] ) );
				if(!$exists){

					$skill->setAttributes($_POST['UserSkill']);

					if ($skill->save()) {

						if (Yii::app()->getRequest()->getIsAjaxRequest())
							Yii::app()->end();
						else
							$this->redirect(array('view', 'id' => $match->user_id ));

					} else {
						$this->redirect(array('view', 'id' => $match->user_id ));
					}
				}
			}

			$this->render('addskill', array( 'skill' => $skill ));
		} else {
			$this->redirect(array('index'));
		}
	}

	public function actionDeleteSkill($id, $skill_id) {

		$match = UserMatch::Model()->findByAttributes( array( 'id' => $id ) );

		//check for permission
		if( $match && ($match->user_id == Yii::app()->user->id || Yii::app()->user->superuser == 1 )){

			$skill = UserSkill::Model()->findByAttributes( array( 'id' => $skill_id ) );

			$skill->delete();

			if (Yii::app()->getRequest()->getIsAjaxRequest())
				Yii::app()->end();
			else
				$this->redirect(array('view', 'id' => $match->user_id ));
		} else {
			$this->redirect(array('profile/'));
		}
	}

	public function actionAddLink($id) {

		//check for permission
		if(Yii::app()->user->id == $id || Yii::app()->user->superuser == 1){ //is this person, or is superuser
			$user_id = $id;
		}

		if($user_id > 0){

			$link = new UserLink;

			if (isset($_POST['UserLink'])) {

				$_POST['UserLink']['user_id'] = $id;
			
				$exists = UserLink::Model()->findByAttributes( array( 'user_id' => $id, 'url' => $_POST['UserLink']['url'] ) );
				if(!$exists){

					$link->setAttributes($_POST['UserLink']);

					if ($link->save()) {

						if (Yii::app()->getRequest()->getIsAjaxRequest())
							Yii::app()->end();
						else
							$this->redirect(array('view', 'id' => $id ));

					} else {
						$this->redirect(array('view', 'id' => $id ));
					}
				}
			}

			$this->render('addlink', array( 'link' => $link ));
		} else {
			$this->redirect(array('profile/'));
		}

	}

	public function actionDeleteLink($id, $link_id) {
		
		//check for permission
		if(Yii::app()->user->id == $id || Yii::app()->user->superuser == 1){ //is this person, or is superuser
			$user_id = $id;
		}

		if($user_id > 0){

			$link = UserLink::Model()->findByAttributes( array( 'id' => $link_id ) );

			$link->delete();

			if (Yii::app()->getRequest()->getIsAjaxRequest())
				Yii::app()->end();
			else
				$this->redirect(array('view', 'id' => $id ));
		} else {
			$this->redirect(array('profile/'));
		}
	}

}