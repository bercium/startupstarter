<?php

class SiteController extends Controller
{
  public $layout="//layouts/card";
  
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
        'actions'=>array("index",'error','logout','about','terms','notify','sugestCountry','sugestSkill','sugestCity'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
        'actions'=>array(),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('list'),
				'users'=>Yii::app()->getModule('user')->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
  
  
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			/*'page'=>array(
				'class'=>'CViewAction',
			),*/
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex($id = 1)
	{
    $this->layout="//layouts/none";
    
		$sqlbuilder = new SqlBuilder;
		$filter = Yii::app()->request->getQuery('filter', array());
		$filter['per_page'] = 3;
		
    
    $searchForm = new SearchForm();
    $searchResult = array();
		$data = array();
    $maxPagePerson = 0;
    $maxPageIdea = 0;
		
		if (isset($_GET['SearchForm'])) $searchForm->setAttributes($_GET['SearchForm']);
		
    if ($searchForm->checkSearchForm()){
			// search results
      $searchForm->setAttributes($_GET['SearchForm']);
			
			$filter['per_page'] = 9;
			$filter['page'] = $id;
			
			$filter['available'] = $searchForm->available;
			$filter['city'] = $searchForm->city;
			$filter['collabpref'] = $searchForm->collabPref;
			$filter['country'] = $searchForm->country;
			$filter['extra'] = $searchForm->extraDetail; // like video or images
			$filter['keywords'] = $searchForm->keywords;
			$filter['language'] = $searchForm->language;
			$filter['skill'] = $searchForm->skill;
			$filter['stage'] = $searchForm->stage;
			
			if ($searchForm->isProject){
				$searchResult['data'] = $sqlbuilder->load_array("search_idea", $filter);
				$count = $sqlbuilder->load_array("search_idea_count", $filter);
				$count = $count['num_of_rows'];
			} else {
				$searchResult['data'] = $sqlbuilder->load_array("search_user", $filter);
				$count = $sqlbuilder->load_array("search_user_count", $filter);
				$count = $count['num_of_rows'];
			}
			
			$searchResult['page'] = $id;
			$searchResult['maxPage'] = ceil($count / $filter['per_page']);

    }else{
			// last results
			$data['idea'] = $sqlbuilder->load_array("recent_updated", $filter);
      $pagedata = $sqlbuilder->load_array("count_idea", $filter);
      $maxPageIdea = ceil($pagedata['num_of_rows'] / $pagedata['filter']['per_page']); 
      
			$data['user'] = $sqlbuilder->load_array("recent_user", $filter);
      $pagedata = $sqlbuilder->load_array("count_user", $filter);
      $maxPagePerson = ceil($pagedata['num_of_rows'] / $pagedata['filter']['per_page']); 
		}
		

		$this->render('index', array('data' => $data, "filter"=>$searchForm, "searchResult"=>$searchResult, "maxPageIdea"=>$maxPageIdea, "maxPagePerson"=>$maxPagePerson));
	}

	public function actionAbout()
	{
    $this->layout="//layouts/none";
		$sqlbuilder = new SqlBuilder;
		$filter = array( 'idea_id' => 1); // our idea ID
		$filter['lang'] = Yii::app()->language;

		$this->render('about', array('idea' => $sqlbuilder->load_array("idea", $filter)));
	}
  

	public function actionNotify()
	{
    if (!Yii::app()->user->isGuest) $this->redirect("index"); //loged in no need to send notifications
    
    if (isset($_POST['email']) && !empty($_POST['email'])){
      $newFilePath = Yii::app()->basePath . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "uploads";
      if (!is_dir($newFilePath)) {
        mkdir($newFilePath, 0777, true);
        //chmod( $newFilePath, 0777 );
      }
      $filecont = '';
      $newFilePath = $newFilePath.DIRECTORY_SEPARATOR."emails.txt";
      if (file_exists($newFilePath)) $filecont = file_get_contents($newFilePath);
      $filecont = $filecont.$_POST['email'].",\n";
      file_put_contents($newFilePath,$filecont);
      
      Yii::app()->user->setFlash("interestMessage",Yii::t('msg',"Your email (".$_POST['email'].") was succesfully saved in our database."));
      $this->refresh();
    }
		$this->render('notify');
	}
	
	public function actionTerms()
	{
		$this->render('terms');
	}	

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
  
  
	public function actionList()
	{
    $this->render('list');
  }

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}


	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionSugestCity() {

		if (!isset($_GET['term'])){
			$response = array("data" => null,
								"status" => 1,
								"message" => Yii::t('msg', "No search query."));
		}else{
			$connection=Yii::app()->db;
			$data = array();
			
			$criteria=new CDbCriteria();
			$criteria->condition = " `name` LIKE :name";
			$criteria->params = array(":name"=>"%".$_GET['term']."%");
			$criteria->order = "name";//, FIELD(LOWER(SUBSTRING(name,".strlen($_GET['term']).")),'".strtolower($_GET['term'])."') DESC";
			
			$dataReader = City::model()->findAll($criteria);
			
			//$data[] = array("value"=>$criteria->order);
			foreach ($dataReader as $row){
				$data[] = array("value"=>$row['name']);
			}
			
			$response = array("data" => $data,
								"status" => 0,
								"message" => '');
		}
		
		echo json_encode($response);
		Yii::app()->end();
	}
	

	public function actionSugestCountry() {

		if (!isset($_GET['term'])){
			$response = array("data" => null,
								"status" => 1,
								"message" => Yii::t('msg', "No search query."));
		}else{
			$connection=Yii::app()->db;
			$data = array();

			$criteria=new CDbCriteria();
			$criteria->condition = " `name` LIKE :name";
			$criteria->params = array(":name"=>"%".$_GET['term']."%");
			$criteria->order = "name";
			
			$dataReader = Country::model()->findAll($criteria);
			foreach ($dataReader as $row){
				$data[] = array("value"=>$row['name']);
			}
			
			$response = array("data" => $data,
												"status" => 0,
												"message" => '');
		}
		
		echo json_encode($response);
		Yii::app()->end();
	}	
	

	public function actionSugestSkill() {

		if (!isset($_GET['term'])){
			$response = array("data" => null,
												"status" => 1,
												"message" => Yii::t('msg', "No search query."));
		}else{
			$language = Yii::app()->language;
			$language = Language::Model()->findByAttributes( array( 'language_code' => $language ) );
			$language = $language->id;

			$connection=Yii::app()->db;
			$data = array();
      		$dataReader = array();
			
			$criteria=new CDbCriteria();
			
			// translated skill sets
			//!!!language
      
			if($language != 40){
				$criteria->condition = " `translation` LIKE :name AND `table` = 'skillset'"; //AND language_id = 
				$criteria->params = array(":name"=>"%".$_GET['term']."%");
				$dataReader = Translation::model()->findAll($criteria);
			}

			//$data = array();
			foreach ($dataReader as $row){
				$data[] = array("value"=>$row['name']);
			}
			
			$criteria->condition = " `name` LIKE :name";
			$criteria->params = array(":name"=>"%".$_GET['term']."%");
			
			// original skill sets
			$dataReader = Skillset::model()->findAll($criteria);

			//$data = array();
			foreach ($dataReader as $row){
				$data[] = array("value"=>$row['name']);
			}

			// skills
			$dataReader = Skill::model()->findAll($criteria);
			
			foreach ($dataReader as $row){
				$data[] = array("value"=>$row['name']);
			}
			
			
			$response = array("data" => $data,
												"status" => 0,
												"message" => '');
		}
		
		echo json_encode($response);
		Yii::app()->end();
	}
	
}
