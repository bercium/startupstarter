<?php

class BackendInviteController extends GxController {

	public function accessRules()
	{
		return array(
			array('allow', // allow admins only
				'users'=>Yii::app()->getModule('user')->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
  
	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Invite'),
		));
	}

	public function actionCreate() {
		$model = new Invite;


		if (isset($_POST['Invite'])) {
			$model->setAttributes($_POST['Invite']);

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
		$model = $this->loadModel($id, 'Invite');


		if (isset($_POST['Invite'])) {
			$model->setAttributes($_POST['Invite']);

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
			$this->loadModel($id, 'Invite')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('msg', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Invite');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Invite('search');
		$model->unsetAttributes();

		if (isset($_GET['Invite']))
			$model->setAttributes($_GET['Invite']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}