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
        'actions'=>array("view","recent", "contact","discover","embed"),
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
    
    if(isset($_GET['ajax'])) $filter['per_page'] = 3;
    else $filter['per_page'] = 12;
		
		$sqlbuilder = new SqlBuilder;
		$users = $sqlbuilder->load_array("recent_user", $filter);
		$pagedata = $sqlbuilder->load_array("count_user", $filter);

		$maxPage = ceil($pagedata['num_of_rows'] / $pagedata['filter']['per_page']);
		
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
  
	public function actionContact($id) { 
    
		if(isset($_POST['message']) && ($_POST['message']  > '')){
      
      $sender = User::model()->findByPk(Yii::app()->user->id);
      $receiver = User::model()->findByPk($id);
      
      $message = new YiiMailMessage;
      $message->view = 'system';
      
      // send to sender
      $message->subject = "New message from ".$sender->name." ".$sender->surname;
      $content = "This message was sent trough cofinder by ".$sender->name." ".$sender->surname.'. '.
                 'To check his profile or to replay <a href="'.Yii::app()->createAbsoluteUrl('/person/view',array('id'=>Yii::app()->user->id)).'">click here</a>.<br /><br /><br />'.
                 GxHtml::encode($_POST['message']);
      $message->setBody(array("content"=>$content), 'text/html');
      //$message->setBody(array("content"=>$_POST['message'],"senderMail"=>$sender->email), 'text/html');
      
      $message->addTo($receiver->email);
      $message->from = Yii::app()->params['adminEmail'];
      Yii::app()->mail->send($message);
      
      // send to self
      $message->subject = "Message send to ".$receiver->name." ".$receiver->surname;
      $content = "You send this message trough cofinder to ".$receiver->name." ".$receiver->surname.'. '.
                 'To check his profile <a href="'.Yii::app()->createAbsoluteUrl('/person/view',array('id'=>$receiver->id)).'">click here</a>.<br /><br /><br />'.
                 GxHtml::encode($_POST['message']);
      $message->setBody(array("content"=>$content), 'text/html');
      //$message->setBody(array("content"=>$_POST['message'],"senderMail"=>$sender->email), 'text/html');
      $message->addTo($sender->email);
      $message->from = Yii::app()->params['adminEmail'];
      Yii::app()->mail->send($message);
      
      // notify
      Yii::app()->user->setFlash('contactPersonMessage', Yii::t("msg","Your message was sent."));
    }else{
      Yii::app()->user->setFlash('contactPersonError', Yii::t("msg","Message can't be empty!"));
    }
    $this->redirect(Yii::app()->createUrl("person/view",array("id"=>$id)));
	}  
  
  
  public function actionEmbed($id){
    $this->layout="//layouts/blank";
    
		$sqlbuilder = new SqlBuilder;
		$filter = array( 'user_id' => $id);

		$this->render('embed', array('user' => $sqlbuilder->load_array("user", $filter)));
  }
  
  public function actionDiscover($id = 1){
    $this->layout="//layouts/none";
    
		$sqlbuilder = new SqlBuilder;
		$filter = Yii::app()->request->getQuery('filter', array());
		$filter['per_page'] = 9;
    $filter['page'] = $id;
		
    
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
			$filter['country'] = $searchForm->country;
			$filter['extra'] = $searchForm->extraDetail; // like video or images
			$filter['keywords'] = $searchForm->keywords;
			$filter['language'] = $searchForm->language;
			$filter['skill'] = $searchForm->skill;
			$filter['stage'] = $searchForm->stage;

			if(isset($_GET['Category'])){
                $keyworder = new Keyworder;
                $category = $keyworder->string2array($_GET['Category']);

				foreach($category AS $value)
				    $filter['category'][] = $value;
			}
			
    		$searchResult['data'] = $sqlbuilder->load_array("search_user", $filter);
			$count = $sqlbuilder->load_array("search_user_count", $filter);
			$count = $count['num_of_rows'];

			$searchResult['page'] = $id;
			$searchResult['maxPage'] = ceil($count / $filter['per_page']); 

    }else{
    		$count = $sqlbuilder->load_array("count_user", $filter);
    		$count = $count['num_of_rows'];

			$searchResult['data'] = $sqlbuilder->load_array("recent_user", $filter);
			$searchResult['page'] = $id;
			$searchResult['maxPage'] = ceil($count / $filter['per_page']); 
    }
		

		$this->render('discover', array("filter"=>$searchForm, "searchResult"=>$searchResult));
  }
	
}
