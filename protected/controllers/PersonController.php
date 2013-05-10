<?php

class PersonController extends GxController {
	
	public $layout="//layouts/view";

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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
        'actions'=>array("view"),
				'users'=>array('*'),
			),
			array('allow', // allow admins only
				'users'=>Yii::app()->getModule('user')->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex() { //create new idea
		/*echo 'Links: <br/><br/>
		/ -> list users <br/>
		/$id -> view user by id <br/>
		<br/>';*/

		$filter = Yii::app()->request->getQuery('filter', array());
		
		$sqlbuilder = new SqlBuilder;
		$data['user'] = $sqlbuilder->load_array("recent_user", $filter);

		$this->render('index', array('data' => $data));
	}

	public function actionView($id) {
		$sqlbuilder = new SqlBuilder;
		$filter = array( 'user_id' => $id);
		$data['user'] = $sqlbuilder->load_array("user", $filter);

		$this->render('index', array('data' => $data));

		$click = new Click;
		$click->user($id, Yii::app()->user->id);
	}

	public function actionRecent($id) {

		$filter = Yii::app()->request->getQuery('filter', array());
		$filter['page'] = $id;
		
		$sqlbuilder = new SqlBuilder;
		$data['user'] = $sqlbuilder->load_array("recent_user", $filter);

		if(isset($_GET['ajax'])){
			$return = htmlspecialchars(json_encode($data), ENT_NOQUOTES);
			echo $return; //return array
			Yii::app()->end();
		} else {
			$this->render('recent', array('data' => $data));
		}
		
	}
	
}