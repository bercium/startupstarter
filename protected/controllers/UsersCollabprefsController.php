<?php

class UsersCollabprefsController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'UsersCollabprefs'),
		));
	}

	public function actionCreate() {
		$model = new UsersCollabprefs;


		if (isset($_POST['UsersCollabprefs'])) {
			$model->setAttributes($_POST['UsersCollabprefs']);

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
		$model = $this->loadModel($id, 'UsersCollabprefs');


		if (isset($_POST['UsersCollabprefs'])) {
			$model->setAttributes($_POST['UsersCollabprefs']);

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
			$this->loadModel($id, 'UsersCollabprefs')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('UsersCollabprefs');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new UsersCollabprefs('search');
		$model->unsetAttributes();

		if (isset($_GET['UsersCollabprefs']))
			$model->setAttributes($_GET['UsersCollabprefs']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}