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
        'actions'=>array("view","recent"),
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
		$pagedata = $sqlbuilder->load_array("count_user", $filter);

		$maxPage = floor($pagedata['num_of_rows'] / $pagedata['filter']['per_page']);


		if(isset($_GET['ajax'])){
			$return['data'] = $this->renderPartial('_recent', array("users" => $data['user'], 'page' => $pagedata['filter']['page'], 'maxPage' => $maxPage), true);
			$return['message'] = '';//Yii::t('msg', "Success!");
			$return['status'] = 0;
			$return = json_encode($return);
			echo $return; //return array
			Yii::app()->end();
		} else {
			$this->render('recent', array('data' => $data, 'pagedata' => $pagedata, 'maxPage' => $maxPage));
		}
		
	}
	
}