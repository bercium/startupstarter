<?php

class CountriesController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Countries'),
		));
	}

	public function actionCreate() {
		$model = new Countries;


		if (isset($_POST['Countries'])) {
			$model->setAttributes($_POST['Countries']);

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
		$model = $this->loadModel($id, 'Countries');


		if (isset($_POST['Countries'])) {
			$model->setAttributes($_POST['Countries']);

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
			$this->loadModel($id, 'Countries')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Countries');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Countries('search');
		$model->unsetAttributes();

		if (isset($_GET['Countries']))
			$model->setAttributes($_GET['Countries']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}