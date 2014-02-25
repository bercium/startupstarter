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
        'actions'=>array("view","embed","discover"),
				'users'=>array('*'),
			),
			array('allow', 
        'actions'=>array("recent"),  // remove after demo
				'users'=>array('@'),
			),
			array('allow', // allow admins only
        'actions'=>array("show"),  // remove after demo
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
		$data['user'] = $sqlbuilder->load_array("user", $filter, "collabpref,link,skillset,idea,gallery,translation");
    
	    if ($data['user'] == array()){
	      throw new CHttpException(400, Yii::t('msg', 'Oops! This person does not exist.'));
	    }
	   
	    $vouched = false;
	    $invited = Invite::model()->findByAttributes(array("receiver_id"=>$id,"registered"=>1));
	    if ($invited){
	      $vouched = $invited->senderId;
	    }

    $responseTime = 0;
    //if (Yii::app()->user->isAdmin()){
      // time to respond on message
      $result = Yii::app()->db->createCommand('SELECT TIMEDIFF(mt.time_sent,mf.time_sent) AS tdif, mt.user_from_id, mt.user_to_id, mt.idea_to_id,mt.time_sent AS rt,mf.time_sent AS rf FROM `message` mf
            LEFT JOIN message mt ON (mt.`user_to_id` = mf.`user_from_id` AND mt.`user_from_id` = mf.`user_to_id` ) OR ((mt.`user_to_id` = mf.`user_from_id` OR mf.`user_to_id` = mt.`user_from_id`) AND mt.`idea_to_id` = mf.`idea_to_id`)
            WHERE NOT ISNULL(mt.id) AND mf.time_sent < mt.time_sent AND mt.user_from_id = '.$id.'
            ORDER BY mf.time_sent ASC')->queryAll();

      if ($result){
        $responseTimeArray = array();

        foreach ($result as $rt_length){
          if (!isset($responseTimeArray[$rt_length['user_to_id']])){
            $rt = timeDifference($rt_length['rt'], $rt_length['rf'],'seconds_total');
            $responseTime += $rt;
            $responseTimeArray[$rt_length['user_to_id']] = 1;
                    //$rt_length['rt']." | ".$rt_length['rf']." = ".timeDifference($rt_length['rt'], $rt_length['rf']);;
          }
        }
        //print_r($responseTimeArray);
        //echo "...".$responseTime;
        if ($responseTime > 0) $responseTime = $responseTime / count($responseTimeArray);
        //echo "...".$responseTime;
      }
    //}
    $lastMsg = Message::model()->findByAttributes(array('user_from_id'=>Yii::app()->user->id,'user_to_id'=>$id),array('order'=>'time_sent DESC'));
    
		$this->render('view', array('data' => $data,"vouched"=>$vouched, 'responseTime'=>$responseTime,'lastMsg'=>$lastMsg));
    
    

		$click = new Click;
		$click->user($id, Yii::app()->user->id);
	}

	public function actionRecent($id = 1) {

		$filter = Yii::app()->request->getQuery('filter', array());
		
		$filter['page'] = $id;
    
	    if(isset($_GET['ajax'])) $filter['per_page'] = 3;
	    else $filter['per_page'] = 12;
		
		$sqlbuilder = new SqlBuilder;
		$users = $sqlbuilder->load_array("recent_users", $filter, "num_of_ideas,skillset");
		$count = $sqlbuilder->load_array("count_users", $filter);

		$maxPage = ceil($count / $filter['per_page']);
		
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
  
	/*public function actionContact($id) {
	}*/
  
  
  public function actionEmbed($id){
    $this->layout="//layouts/blank";
    
		$sqlbuilder = new SqlBuilder;
		$filter = array( 'user_id' => $id);

		$this->render('embed', array('user' => $sqlbuilder->load_array("user", $filter, "num_of_ideas,skillset")));
  }
  
  public function actionDiscover($id = 1){
    $this->layout="//layouts/none";
    
		$sqlbuilder = new SqlBuilder;
		$filter = Yii::app()->request->getQuery('filter', array());
		
    if (Yii::app()->user->isGuest){
      $_GET['SearchForm'] = '';
      $filter['per_page'] = 3;
      $filter['page'] = 1;
      $register = '<a href="'.Yii::app()->createUrl("user/registration").'" class="button small radius secondary ml10 mb0">'.Yii::t('app','register').'</a>';
      setFlash("discoverPerson", Yii::t('msg','Only recent three results are shown!<br />To get full functionality please login or {register}',array('{register}'=>$register)), "alert", false);
    }else{      
      $filter['per_page'] = 9;
      $filter['page'] = $id;
    }    
    
    $searchForm = new SearchForm();
    $searchForm->isProject = false;
    
    $searchResult = array();
		
		if (isset($_GET['SearchForm'])) $searchForm->setAttributes($_GET['SearchForm']);
		
    if ($searchForm->checkSearchForm()){
			// search results
      $searchForm->setAttributes($_GET['SearchForm']);
			
			
			$filter['available'] = $searchForm->available;
			$filter['city'] = $searchForm->city;
			$filter['collabpref'] = $searchForm->collabPref;
			$filter['skill'] = $searchForm->skill;
			$filter['stage'] = $searchForm->stage;
			$filter['user'] = $searchForm->user; //this one is IN


			if(isset($_GET['Category'])){
                $keyworder = new Keyworder;
                $category = $keyworder->string2array($_GET['Category']);

				foreach($category AS $value)
				    $filter['category'][] = $value;
			}
			
			$search = $sqlbuilder->load_array("search_users", $filter, "num_of_ideas,skillset");
    		$searchResult['data'] = $search['results'];
			$count = $search['count'];

			$searchResult['page'] = $id;
			$searchResult['maxPage'] = ceil($count / $filter['per_page']); 

    }else{
    		$count = $sqlbuilder->load_array("count_users", $filter);

			$searchResult['data'] = $sqlbuilder->load_array("recent_users", $filter, "num_of_ideas,skillset");
			$searchResult['page'] = $id;
			$searchResult['maxPage'] = ceil($count / $filter['per_page']); 
    }
		

		$this->render('discover', array("filter"=>$searchForm, "searchResult"=>$searchResult));
  }
  
  /**
   * decode person form code and show his profile
   */
  public function actionShow($id) {
    Yii::import('application.helpers.Hashids');
    $hashids = new Hashids('cofinder');
    $user_id = $hashids->decrypt($id);
    //die(print_r($user_id,true));
    
    $this->redirect(Yii::app()->createUrl("person",array("id"=>$user_id[0])));
    Yii::app()->end();
  }
	
}
