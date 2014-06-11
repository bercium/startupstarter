<?php

class BackendTagIdeaController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'TagIdea'),
		));
	}

	public function actionCreate() {
		$model = new TagIdea;


		if (isset($_POST['TagIdea'])) {
			$model->setAttributes($_POST['TagIdea']);

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
		$model = $this->loadModel($id, 'TagIdea');


		if (isset($_POST['TagIdea'])) {
			$model->setAttributes($_POST['TagIdea']);

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
			$this->loadModel($id, 'TagIdea')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('msg', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('TagIdea');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new TagIdea('search');
		$model->unsetAttributes();

		if (isset($_GET['TagIdea']))
			$model->setAttributes($_GET['TagIdea']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}