<?php

class BackendMembertypeController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Membertype'),
		));
	}

	public function actionCreate() {
		$model = new Membertype;


		if (isset($_POST['Membertype'])) {
			$model->setAttributes($_POST['Membertype']);

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
		$model = $this->loadModel($id, 'Membertype');


		if (isset($_POST['Membertype'])) {
			$model->setAttributes($_POST['Membertype']);

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
			$this->loadModel($id, 'Membertype')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('msg', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Membertype');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Membertype('search');
		$model->unsetAttributes();

		if (isset($_GET['Membertype']))
			$model->setAttributes($_GET['Membertype']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}