<?php

class SkillsetsController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Skillsets'),
		));
	}

	public function actionCreate() {
		$model = new Skillsets;


		if (isset($_POST['Skillsets'])) {
			$model->setAttributes($_POST['Skillsets']);

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
		$model = $this->loadModel($id, 'Skillsets');


		if (isset($_POST['Skillsets'])) {
			$model->setAttributes($_POST['Skillsets']);

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
			$this->loadModel($id, 'Skillsets')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Skillsets');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Skillsets('search');
		$model->unsetAttributes();

		if (isset($_GET['Skillsets']))
			$model->setAttributes($_GET['Skillsets']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}