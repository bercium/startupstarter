<?php

class SiteController extends Controller
{
  public $layout="//layouts/card";
  public $justContent=false;
  
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
			array('allow', // allow all users to perform actions
        'actions'=>array('index','error','logout','about','terms','notify','notifyFacebook','suggestCountry',
                         'suggestSkill','suggestCity','unbsucribeFromNews','cookies','sitemap','startupEvents'),
				'users'=>array('*'),
			),
			/*array('allow', // allow authenticated user to perform 'create' and 'update' actions
        'actions'=>array(),
				'users'=>array('@'),
			),*/
			array('allow', // allow admin user to perform actions:
				'actions'=>array('list','recalcPerc'),
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

			//categories work like this
			/*foreach($filter AS $key => $value){
				if(strlen($value) > 0 && $value){
					$filter['category'][] = $key;
				}
			}*/
			
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
    $savedToDB = false;
    if (!empty($_POST['email'])){
      
      $invitee = User::model()->findByAttributes(array("email"=>$_POST['email']));
      if ($invitee){
        $login = '<a data-dropdown="drop-login" class="button radius small" style="margin-bottom:0;" href="#">'.Yii::t('app','Login').'</a>';
        setFlash("interestMessage",Yii::t('msg','You have already registered. Please {login}',array('{login}' => $login)));
      }else{
      
        $invite = Invite::model()->findByAttributes(array('email' => $_POST['email'],'idea_id'=>null));
        if ($invite){
          if ($invite->key){
            $activation_url = Yii::app()->createAbsoluteUrl('/user/registration')."?id=".$invite->key;
            $button = "<a href='".$activation_url."' class='button radius small' style='margin-bottom: 3px;'>".Yii::t('app',"Register here")."</a>";
            setFlash("interestMessage",Yii::t('msg',"You already have an invitation pending. To join please click {button} or copy this url:<br>{url}",array('{button}'=>$button,"{url}"=>$activation_url)),"info",false);
          }else setFlash("interestMessage",Yii::t('msg',"We already have you on our list."),'alert');
        }else{

          /*$newFilePath = Yii::app()->basePath . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "uploads";
          if (!is_dir($newFilePath)) {
            mkdir($newFilePath, 0777, true);
            //chmod( $newFilePath, 0777 );
          }
          $filecont = '';
          $newFilePath = $newFilePath.DIRECTORY_SEPARATOR."emails.txt";
          if (file_exists($newFilePath)) $filecont = file_get_contents($newFilePath);
          $filecont = $filecont.$_POST['email'].",\n";
          file_put_contents($newFilePath,$filecont);*/

          $invitation = new Invite();
          $invitation->email = $_POST['email'];
          
          if (!empty($_GET['code'])) $invitation->code = $_GET['code'];

          if ($invitation->save()){
            $savedToDB = true;
            $message = new YiiMailMessage;
            $message->view = 'system';

            $message->subject = "Requested invitation for Cofinder";
            $content = 'Thank you for your interest in joining <a href="http://www.cofinder.eu">Cofinder</a>!
                        <br><br><br>Please take a minute and answer 5 questions in this form (https://docs.google.com/forms/d/1I5gNvjMB8A9OpSbdXs397dqbPOdF7L9eGQfUoh8edhI/viewform).
                        This will give us a better understanding where in our community you fit the best.
                        <br><br>Thank you, Cofinder team!';
            $message->setBody(array("content"=>$content), 'text/html');

            $message->addTo($_POST['email']);
            $message->from = Yii::app()->params['noreplyEmail'];
            Yii::app()->mail->send($message);
      
            setFlash("interestMessage",Yii::t('msg',"Your email ({email}) was succesfully saved in our database.",array('{email}'=>$_POST['email'])));
          }else{
            setFlash("interestMessage",Yii::t('msg',"Something went wrong while saving your ({email}) in our database.",array('{email}'=>$_POST['email'])),"alert");
          }
        }
      }
      //$this->refresh();
    }
		$this->render('notify',array("saved"=>$savedToDB));
	}
  
  public function actionNotifyFacebook(){
    $this->justContent = true;  // show no header and footer
    $this->actionNotify();
  }
  
  
  public function actionUnbsucribeFromNews(){
    $this->pageTitle = "Unsubscription";
    if (!empty($_GET['email'])){
      Invite::model()->deleteAll("email = :email AND registered = :registered",array(':email' => $_GET['email'],':registered'=>false));
    }else
    if (!empty($_GET['id'])){
      $user = User::model()->findByAttributes(array('activkey'=>$_GET['id'],'newsletter'=>'1'));
      if ($user){
        $user->newsletter = 0;
        $user->activkey = md5(microtime().$_GET['id']);
        $user->save();
      }
    }
    $this->render('message',array('title'=>'Unsubscribe','content'=>Yii::t('msg','You have successfully unsubscribed from our newsletter.')));
  }
  
	
	public function actionTerms()
	{
    $this->layout = 'none';
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
  
  
  public function actionCookies(){
    $this->layout = 'card';
    $this->render('cookies');
  }


	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionSuggestCity() {
    
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
	

	public function actionSuggestCountry() {

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
	

	public function actionSuggestSkill() {

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
      if ($dataReader){
        foreach ($dataReader as $row){
          $data[] = array("value"=>$row['translation']);
        }
      }
			
			$criteria->condition = " `name` LIKE :name";
			$criteria->params = array(":name"=>"%".$_GET['term']."%");
			
			// original skill sets
			$dataReader = Skillset::model()->findAll($criteria);

			//$data = array();
      if ($dataReader){
        foreach ($dataReader as $row){
          $data[] = array("value"=>$row['name']);
        }
      }

			// skills
			$dataReader = Skill::model()->findAll($criteria);
			
      if ($dataReader){
        foreach ($dataReader as $row){
          $data[] = array("value"=>$row['name']);
        }
      }
			
			
			$response = array("data" => $data,
												"status" => 0,
												"message" => '');
		}
		
		echo json_encode($response);
		Yii::app()->end();
	}
  
  // recalculate percentage for all users
  public function actionRecalcPerc(){
    $comp = new Completeness();
    
    $users = User::model()->findAll();
    foreach ($users as $user){
      $comp->init($user->id);
      $comp->setPercentage($user->id);
    }
    $this->render("list");
  }
  
  
  /**
   * hide toolbar
   */
  protected function beforeAction($action){
    if ($action->id == 'sitemap')
      foreach (Yii::app()->log->routes as $route){
        //if ($route instanceof CWebLogRoute){
          $route->enabled = false;
        //}
      }
    return true;
  }
  
  /**
   * create sitemap for the whole site
   */
  public function actionSitemap(){
    // don't allow any other strings before this
    Yii::app()->clientScript->reset();
    $this->layout = 'blank'; // template blank
    
    $sitemapResponse=<<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    <url>
      <loc>http://www.cofinder.eu/</loc>
      <changefreq>daily</changefreq>
      <priority>0.90</priority>
    </url>
    <url>
      <loc>http://www.cofinder.eu/person/discover</loc>
      <changefreq>daily</changefreq>
      <priority>0.90</priority>
    </url>
    <url>
      <loc>http://www.cofinder.eu/project/discover</loc>
      <changefreq>daily</changefreq>
      <priority>0.90</priority>
    </url>    
    <url>
      <loc>http://www.cofinder.eu/site/about</loc>
      <changefreq>monthly</changefreq>
      <priority>0.60</priority>
    </url>
    <url>
      <loc>http://www.cofinder.eu/site/notify</loc>
      <changefreq>monthly</changefreq>
      <priority>0.30</priority>
    </url>
    <url>
      <loc>http://www.cofinder.eu/user/login</loc>
      <changefreq>yearly</changefreq>
      <priority>0.30</priority>
    </url>
    <url>
      <loc>http://www.cofinder.eu/user/recovery</loc>
      <changefreq>yearly</changefreq>
      <priority>0.20</priority>
    </url>
    <url>
      <loc>http://www.cofinder.eu/site/terms</loc>
      <changefreq>monthly</changefreq>
      <priority>0.40</priority>
    </url>
    <url>
      <loc>http://www.cofinder.eu/site/cookies</loc>
      <changefreq>monthly</changefreq>
      <priority>0.40</priority>
    </url>
    
EOD;
    
    // get user completeness for setting priority
    $usersStat = UserStat::model()->findAll();
    $complete = array();
    foreach ($usersStat as $us){
      $complete[$us['user_id']] = $us['completeness'];
    }
    
    // go trough all active users and write them out
    $users = User::model()->findAllByAttributes(array('status'=>1));
    foreach ($users as $user){
      $priority = 60;
      if (isset($complete[$user['id']])){
        $priority += round($complete[$user['id']]/5,0);
      }
      $sitemapResponse .= "
      <url>
        <loc>".Yii::app()->createAbsoluteUrl('person',array("id"=>$user['id']))."</loc>
        <changefreq>weekly</changefreq>
        <priority>0.".$priority."</priority>
      </url>";
    }
    
    // go trough all active projects and write them out
    $ideas = Idea::model()->findAllByAttributes(array('deleted'=>0));
    foreach ($ideas as $idea){
      IdeaTranslation::model();
      $priority = 70;
      foreach ($idea->ideaTranslations as $trans){
        if ($trans->language->language_code != 'en'){
          $ar = array("id"=>$idea['id'],"lang"=>$trans->language->language_code);
        }else{
          $ar = array("id"=>$idea['id']);
        }
        
        $sitemapResponse .= "
        <url>
          <loc>".Yii::app()->createAbsoluteUrl('project',$ar)."</loc>
          <changefreq>weekly</changefreq>
          <priority>0.".$priority."</priority>
        </url>";
      }
    }    
    
    $sitemapResponse .= "\n</urlset>"; // end sitemap
    
    $this->render("//layouts/blank",array("content"=>$sitemapResponse));
  }  
  

  /**
   * inport.io connect function
   */
  private function query($connectorGuid, $input, $userGuid, $apiKey) {

    $url = "https://api.import.io/store/connector/" . $connectorGuid . "/_query?_user=" . urlencode($userGuid) . "&_apikey=" . urlencode($apiKey);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS,  json_encode(array("input" => $input)));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode($result);
  }
  
  /**
   * load calendars
   */
  public function actionStartupEvents(){
    $this->layout = "//layouts/none";
    $events = array();
    
    $filename = "calendar.json";
    $folder = Yii::app()->basePath.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR.Yii::app()->params['tempFolder'];
      
    //if (!file_exists($folder.$filename)){
    if (true){    
      $controller = 'general';
      $action = 'loadCalendars';
      
      $commandPath = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'commands';
      $runner = new CConsoleCommandRunner();
      $runner->addCommands($commandPath);
      $commandPath = Yii::getFrameworkPath() . DIRECTORY_SEPARATOR . 'cli' . DIRECTORY_SEPARATOR . 'commands';
      $runner->addCommands($commandPath);

      $args = array('yiic', $controller, $action); // 'migrate', '--interactive=0'
      //$args = array_merge(array("yiic"), $args);
      //ob_start();
      $runner->run($args);
    }
    
    if (file_exists($folder.$filename)){
      $content = file_get_contents($folder.$filename);
      $events = json_decode($content, true);
    }
    
    /*echo "<pre>";
    print_r($events);
    echo "</pre>";*/
    if (Yii::app()->user->isGuest){
      $invite = '<a href="'.Yii::app()->createUrl("site/notify").'" class="button small radius secondary ml10 mb0">'.Yii::t('app','invitation').'</a>';    
      setFlash("discoverPerson", Yii::t('msg','To see all events please login or request {invite}',array('{invite}'=>$invite)), "alert", false);
    }
    $this->render("calendar",array("events"=>$events));
  }
	
}
