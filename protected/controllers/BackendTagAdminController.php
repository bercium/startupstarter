<?php

class BackendTagAdminController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'TagAdmin'),
		));
	}

	public function actionCreate() {
		$model = new TagAdmin;


		if (isset($_POST['TagAdmin'])) {
			$model->setAttributes($_POST['TagAdmin']);

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
		$model = $this->loadModel($id, 'TagAdmin');


		if (isset($_POST['TagAdmin'])) {
			$model->setAttributes($_POST['TagAdmin']);

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
			$this->loadModel($id, 'TagAdmin')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('msg', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('TagAdmin');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new TagAdmin('search');
		$model->unsetAttributes();

		if (isset($_GET['TagAdmin']))
			$model->setAttributes($_GET['TagAdmin']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}