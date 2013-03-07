<?php

class IdeasTranslationsController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'IdeasTranslations'),
		));
	}

	public function actionCreate() {
		$model = new IdeasTranslations;


		if (isset($_POST['IdeasTranslations'])) {
			$model->setAttributes($_POST['IdeasTranslations']);

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
		$model = $this->loadModel($id, 'IdeasTranslations');


		if (isset($_POST['IdeasTranslations'])) {
			$model->setAttributes($_POST['IdeasTranslations']);

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
			$this->loadModel($id, 'IdeasTranslations')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('IdeasTranslations');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new IdeasTranslations('search');
		$model->unsetAttributes();

		if (isset($_GET['IdeasTranslations']))
			$model->setAttributes($_GET['IdeasTranslations']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}