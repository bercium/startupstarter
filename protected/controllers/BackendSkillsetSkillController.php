<?php

class BackendSkillsetSkillController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'SkillsetSkill'),
		));
	}

	public function actionCreate() {
		$model = new SkillsetSkill;


		if (isset($_POST['SkillsetSkill'])) {
			$model->setAttributes($_POST['SkillsetSkill']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'SkillsetSkill');


		if (isset($_POST['SkillsetSkill'])) {
			$model->setAttributes($_POST['SkillsetSkill']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'SkillsetSkill')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('msg', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('SkillsetSkill');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new SkillsetSkill('search');
		$model->unsetAttributes();

		if (isset($_GET['SkillsetSkill']))
			$model->setAttributes($_GET['SkillsetSkill']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}