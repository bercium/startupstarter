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
		/translate/$id -> add translation by idea id <br/>
		/editTranslation/$id?lang=$language_code -> edit translation by idea id and language code (2 letter code, sl/en/..) <br/>
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
		$idea = $this->loadModel($id, 'Idea');
		if($lang){
			$language = Language::Model()->findByAttributes( array( 'language_code' => $lang ) );
			$translation = IdeaTranslation::Model()->findByAttributes( array( 'idea_id' => $idea->id, 'language_id' => $language->id ) );
		} else {
			$translation = IdeaTranslation::Model()->findByAttributes( array( 'idea_id' => $idea->id ) );

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

		$this->render('updateidea', array( 'idea' => $idea, 'translation' => $translation ));
	}

	public function actionTranslate($id) {
		$idea = $this->loadModel($id, 'Idea');
		$translation = new IdeaTranslation;

		if (isset($_POST['IdeaTranslation'])) {
			$_POST['IdeaTranslation']['idea_id'] = $id;

			$exists = IdeaTranslation::Model()->findByAttributes( array( 'idea_id' => $idea->id, 'language_id' => $_POST['IdeaTranslation']['language_id'] ) );
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
	}

	public function actionEditTranslation($id, $lang) {
		$idea = $this->loadModel($id, 'Idea');
		$language = Language::Model()->findByAttributes( array( 'language_code' => $lang ) );
		$translation = IdeaTranslation::Model()->findByAttributes( array( 'idea_id' => $idea->id, 'language_id' => $language->id ) );

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
	}

	/*
	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Idea')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Idea');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Idea('search');
		$model->unsetAttributes();

		if (isset($_GET['Idea']))
			$model->setAttributes($_GET['Idea']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
*/
}