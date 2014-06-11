<?php

class BackendTagEventController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'TagEvent'),
		));
	}

	public function actionCreate() {
		$model = new TagEvent;


		if (isset($_POST['TagEvent'])) {
			$model->setAttributes($_POST['TagEvent']);

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
		$model = $this->loadModel($id, 'TagEvent');


		if (isset($_POST['TagEvent'])) {
			$model->setAttributes($_POST['TagEvent']);

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
			$this->loadModel($id, 'TagEvent')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('msg', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('TagEvent');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new TagEvent('search');
		$model->unsetAttributes();

		if (isset($_GET['TagEvent']))
			$model->setAttributes($_GET['TagEvent']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}