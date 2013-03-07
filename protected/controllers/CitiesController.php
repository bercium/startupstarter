<?php

class CitiesController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Cities'),
		));
	}

	public function actionCreate() {
		$model = new Cities;


		if (isset($_POST['Cities'])) {
			$model->setAttributes($_POST['Cities']);

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
		$model = $this->loadModel($id, 'Cities');


		if (isset($_POST['Cities'])) {
			$model->setAttributes($_POST['Cities']);

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
			$this->loadModel($id, 'Cities')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Cities');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Cities('search');
		$model->unsetAttributes();

		if (isset($_GET['Cities']))
			$model->setAttributes($_GET['Cities']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}