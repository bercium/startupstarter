<?php

class IdeasStatusesController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'IdeasStatuses'),
		));
	}

	public function actionCreate() {
		$model = new IdeasStatuses;


		if (isset($_POST['IdeasStatuses'])) {
			$model->setAttributes($_POST['IdeasStatuses']);

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
		$model = $this->loadModel($id, 'IdeasStatuses');


		if (isset($_POST['IdeasStatuses'])) {
			$model->setAttributes($_POST['IdeasStatuses']);

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
			$this->loadModel($id, 'IdeasStatuses')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('IdeasStatuses');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new IdeasStatuses('search');
		$model->unsetAttributes();

		if (isset($_GET['IdeasStatuses']))
			$model->setAttributes($_GET['IdeasStatuses']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}