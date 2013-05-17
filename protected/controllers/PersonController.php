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
        'actions'=>array("view","recent", "contact"),
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

  
	public function actionView($id) {
    $this->layout="//layouts/none";
    
		$sqlbuilder = new SqlBuilder;
		$filter = array( 'user_id' => $id);
		$data['user'] = $sqlbuilder->load_array("user", $filter);

		$this->render('view', array('data' => $data));

		$click = new Click;
		$click->user($id, Yii::app()->user->id);
	}

	public function actionRecent($id = 1) {

		$filter = Yii::app()->request->getQuery('filter', array());
		
		$filter['page'] = $id;
		//$filter['page'] = 1; // !!! remove
    
    if(isset($_GET['ajax'])) $filter['per_page'] = 3;
    else $filter['per_page'] = 12;
		
		$sqlbuilder = new SqlBuilder;
		$users = $sqlbuilder->load_array("recent_user", $filter);
		$pagedata = $sqlbuilder->load_array("count_user", $filter);

		$maxPage = floor($pagedata['num_of_rows'] / $pagedata['filter']['per_page']);
		
		//$maxPage = 3;  // !!! remove

		if(isset($_GET['ajax'])){
			$return['data'] = $this->renderPartial('_recent', array("users" => $users, 'page' => $id, 'maxPage' => $maxPage), true);
			$return['message'] = '';//Yii::t('msg', "Success!");
			$return['status'] = 0;
			$return = json_encode($return);
			echo $return; //return array
			Yii::app()->end();
		} else {
			$this->render('recent', array('users' => $users, 'page' => $id, 'maxPage' => $maxPage));
		}
		
	}
  
	public function actionContact() { //create new idea
		/*echo 'Links: <br/><br/>
		/ -> list users <br/>
		/$id -> view user by id <br/>
		<br/>';*/
		if(isset($_GET['ajax'])){
			$return['data'] = $this->renderPartial('_recent', array("users" => $users, 'page' => $id, 'maxPage' => $maxPage), true);
			$return['message'] = '';//Yii::t('msg', "Success!");
			$return['status'] = 0;
			$return = json_encode($return);
			echo $return; //return array
			Yii::app()->end();
    }
	}  
	
}