<?php

class CollabprefsController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Collabprefs'),
		));
	}

	public function actionCreate() {
		$model = new Collabprefs;


		if (isset($_POST['Collabprefs'])) {
			$model->setAttributes($_POST['Collabprefs']);

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
		$model = $this->loadModel($id, 'Collabprefs');


		if (isset($_POST['Collabprefs'])) {
			$model->setAttributes($_POST['Collabprefs']);

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
			$this->loadModel($id, 'Collabprefs')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Collabprefs');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Collabprefs('search');
		$model->unsetAttributes();

		if (isset($_GET['Collabprefs']))
			$model->setAttributes($_GET['Collabprefs']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}