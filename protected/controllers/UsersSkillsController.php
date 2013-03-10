<?php

class UsersSkillsController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'UsersSkills'),
		));
	}

	public function actionCreate() {
		$model = new UsersSkills;


		if (isset($_POST['UsersSkills'])) {
			$model->setAttributes($_POST['UsersSkills']);

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
		$model = $this->loadModel($id, 'UsersSkills');


		if (isset($_POST['UsersSkills'])) {
			$model->setAttributes($_POST['UsersSkills']);

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
			$this->loadModel($id, 'UsersSkills')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('UsersSkills');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new UsersSkills('search');
		$model->unsetAttributes();

		if (isset($_GET['UsersSkills']))
			$model->setAttributes($_GET['UsersSkills']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}