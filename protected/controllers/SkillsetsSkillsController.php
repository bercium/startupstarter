<?php

class SkillsetsSkillsController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'SkillsetsSkills'),
		));
	}

	public function actionCreate() {
		$model = new SkillsetsSkills;


		if (isset($_POST['SkillsetsSkills'])) {
			$model->setAttributes($_POST['SkillsetsSkills']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->ID));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'SkillsetsSkills');


		if (isset($_POST['SkillsetsSkills'])) {
			$model->setAttributes($_POST['SkillsetsSkills']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->ID));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'SkillsetsSkills')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('SkillsetsSkills');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new SkillsetsSkills('search');
		$model->unsetAttributes();

		if (isset($_GET['SkillsetsSkills']))
			$model->setAttributes($_GET['SkillsetsSkills']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}