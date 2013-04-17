<?php

class BackendIdeaMemberController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'IdeaMember'),
		));
	}

	public function actionCreate() {
		$model = new IdeaMember;


		if (isset($_POST['IdeaMember'])) {
			$model->setAttributes($_POST['IdeaMember']);

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
		$model = $this->loadModel($id, 'IdeaMember');


		if (isset($_POST['IdeaMember'])) {
			$model->setAttributes($_POST['IdeaMember']);

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
			$this->loadModel($id, 'IdeaMember')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('IdeaMember');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new IdeaMember('search');
		$model->unsetAttributes();

		if (isset($_GET['IdeaMember']))
			$model->setAttributes($_GET['IdeaMember']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}