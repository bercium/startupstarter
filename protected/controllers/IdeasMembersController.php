<?php

class IdeasMembersController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'IdeasMembers'),
		));
	}

	public function actionCreate() {
		$model = new IdeasMembers;


		if (isset($_POST['IdeasMembers'])) {
			$model->setAttributes($_POST['IdeasMembers']);

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
		$model = $this->loadModel($id, 'IdeasMembers');


		if (isset($_POST['IdeasMembers'])) {
			$model->setAttributes($_POST['IdeasMembers']);

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
			$this->loadModel($id, 'IdeasMembers')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('IdeasMembers');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new IdeasMembers('search');
		$model->unsetAttributes();

		if (isset($_GET['IdeasMembers']))
			$model->setAttributes($_GET['IdeasMembers']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}