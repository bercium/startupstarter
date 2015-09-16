<?php

class BackendUserController extends GxController {
  
  /**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
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
			'model' => $this->loadModel($id, 'BackendUser'),
		));
	}

	public function actionCreate() {
		$model = new BackendUser;


		if (isset($_POST['BackendUser'])) {
			$model->setAttributes($_POST['BackendUser']);

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
		$model = $this->loadModel($id, 'BackendUser');


		if (isset($_POST['BackendUser'])) {
			$model->setAttributes($_POST['BackendUser']);

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
			$this->loadModel($id, 'BackendUser')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('msg', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('BackendUser');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new BackendUser('search');
		$model->unsetAttributes();

		if (isset($_GET['BackendUser']))
			$model->setAttributes($_GET['BackendUser']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
  
  public function actionInactive() {
    $this->layout="//layouts/card";
    $users = User::model()->findAllByAttributes(array("status"=>0,"lastvisit_at"=>'0000-00-00 00:00:00'),array('order'=>'create_at DESC'));
    $this->render('inactive',array("users"=>$users));
  }

}