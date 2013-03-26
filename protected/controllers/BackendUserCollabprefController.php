<?php

class BackendUserCollabprefController extends GxController {

 
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
			'model' => $this->loadModel($id, 'UserCollabpref'),
		));
	}

	public function actionCreate() {
		$model = new UserCollabpref;


		if (isset($_POST['UserCollabpref'])) {
			$model->setAttributes($_POST['UserCollabpref']);

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
		$model = $this->loadModel($id, 'UserCollabpref');


		if (isset($_POST['UserCollabpref'])) {
			$model->setAttributes($_POST['UserCollabpref']);

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
			$this->loadModel($id, 'UserCollabpref')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('UserCollabpref');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new UserCollabpref('search');
		$model->unsetAttributes();

		if (isset($_GET['UserCollabpref']))
			$model->setAttributes($_GET['UserCollabpref']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}