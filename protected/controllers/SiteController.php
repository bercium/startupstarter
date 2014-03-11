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
                         'suggestSkill','suggestCity','unbsucribeFromNews','cookies','sitemap','startupEvents',
                         'applyForEvent','vote','clearNotif'),
				'users'=>array('*'),
			),
			/*array('allow', // allow authenticated user to perform 'create' and 'update' actions
        'actions'=>array(),
				'users'=>array('@'),
			),*/
			array('allow', // allow admin user to perform actions:
				'actions'=>array('list','recalcPerc','setVanityUrl','sqlIndustry'),
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

		//suggested / recent switch button
		if(isset($_GET['suggested']) && $_GET['suggested'] == true){
			$_SESSION['suggested'] = true;
		} elseif(isset($_GET['suggested']) && $_GET['suggested'] == false) {
			$_SESSION['suggested'] = false;
		}
		
    if(!Yii::app()->user->isGuest && isset($_SESSION['suggested']) && $_SESSION['suggested'] == true){

		//users
		 	$filter = new FilterFromProfile;
		 	$filter = $filter->search("userByProject", Yii::app()->user->id);
		 	$filter['page'] = 1;
		 	$filter['per_page'] = 3;
		 	$filter['recent'] = 'recent';
		 	$filter['where'] = "AND u.create_at > ".(time() - 3600 * 24 * 14);
			$search = $sqlbuilder->load_array("search_users", $filter, "num_of_ideas,skill,industry");
			$userType = Yii::t('app', "Suggested users").' <a href="?suggested=0" trk="person_switch_recent" class="button radius tiny">'.Yii::t('app', "Switch to recent").'</a>';

			//if there's not plenty of results...
			if($search['count'] < 3){
			 	$filter['where'] = "AND u.create_at > ".(time() - 3600 * 24 * 31);
				$search = $sqlbuilder->load_array("search_users", $filter, "num_of_ideas,skill,industy");
				if($search['count'] < 3){
					$search['results'] = $sqlbuilder->load_array("recent_users", $filter, "num_of_ideas,skill,industry");
					$search['count'] = $sqlbuilder->load_array("count_users", $filter);
					$userType = Yii::t('app', "No suggested users showing recent");
				}
			}

      $data['user'] = $search['results'];
      $maxPagePerson = ceil($search['count'] / $filter['per_page']);

    //ideas
      $filter = new FilterFromProfile;
      $filter = $filter->search("ideaByProfile", Yii::app()->user->id);
      $filter['page'] = 1;
      $filter['per_page'] = 3;
      $filter['recent'] = 'recent';
      $filter['where'] = "AND i.time_updated > ".(time() - 3600 * 24 * 14);
      $search = $sqlbuilder->load_array("search_ideas", $filter, "translation,member,candidate,skill,industry");
      $ideaType = Yii::t('app', "Suggested projects").' <a href="?suggested=0" trk="project_switch_recent" class="button radius tiny">'.Yii::t('app', "Switch to recent").'</a>';
    		
			//if there's not plenty of results...
			if($search['count'] < 3){
			 	$filter['where'] = "AND i.time_updated > ".(time() - 3600 * 24 * 31);
				$search = $sqlbuilder->load_array("search_users", $filter, "translation,member,candidate,skill,industry");
				if($search['count'] < 3){
		  			$search['results'] = $sqlbuilder->load_array("recent_ideas", $filter, "translation,member,candidate,skill,industry");
					$search['count'] = $count = $sqlbuilder->load_array("count_ideas", $filter);
					$ideaType = Yii::t('app', "No suggested projects showing recent");
				}
			}

    		$data['idea'] = $search['results'];
    		$maxPageIdea = ceil($search['count'] / $filter['per_page']);

    } else {
			// last results

			$filter['per_page'] = 3;

			$data['user'] = $sqlbuilder->load_array("recent_users", $filter, "num_of_ideas,skill,industry");
	      	$count = $sqlbuilder->load_array("count_users", $filter);
	      	$maxPagePerson = ceil($count / $filter['per_page']);
	    $userType = Yii::t('app', "Recent users");
      if (!Yii::app()->user->isGuest) $userType .= ' <a href="?suggested=1" trk="person_switch_suggested" class="button radius tiny">'.Yii::t('app', "Switch to suggested").'</a>';

      $data['idea'] = $sqlbuilder->load_array("recent_ideas", $filter, "translation,member,candidate,skill,industry");
        $count = $sqlbuilder->load_array("count_ideas", $filter);
        $maxPageIdea = ceil($count / $filter['per_page']);
      $ideaType = Yii::t('app', "Recent projects");
      if (!Yii::app()->user->isGuest) $ideaType .= ' <a href="?suggested=1" trk="project_switch_suggested" class="button radius tiny">'.Yii::t('app', "Switch to suggested").'</a>';        
    }

		$this->render('index', array('data' => $data, "maxPageIdea"=>$maxPageIdea, "maxPagePerson"=>$maxPagePerson, "ideaType"=>$ideaType, "userType"=>$userType));
	}

	public function actionAbout()
	{
    $this->layout="//layouts/none";
		$sqlbuilder = new SqlBuilder;
		$filter = array( 'idea_id' => 1); // our idea ID
		$filter['lang'] = Yii::app()->language;

		$this->render('about', array('idea' => $sqlbuilder->load_array("idea", $filter, "translation,member,candidate,skill,industry")));
	}
  

	public function actionNotify()
	{
    //$this->redirect("user/registration");
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

            $message->setTo($_POST['email']);
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
	      $data = CSkills::skillSuggest($_GET['term']);
	      /*foreach ($dataReader as $row){
	        $data[] = $row;
	      }*/

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
      <loc>http://www.cofinder.eu/site/startupEvents</loc>
      <changefreq>monthly</changefreq>
      <priority>0.60</priority>
    </url>
    <url>
      <loc>http://www.cofinder.eu/site/about</loc>
      <changefreq>monthly</changefreq>
      <priority>0.60</priority>
    </url>
    <url>
      <loc>http://www.cofinder.eu/user/registration</loc>
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
      
    if (!file_exists($folder.$filename) || YII_DEBUG){
    //if (true){    
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
    /*if (Yii::app()->user->isGuest){
      $register = '<a href="'.Yii::app()->createUrl("user/registration").'" class="button small radius secondary ml10 mb0">'.Yii::t('app','register').'</a>';    
      setFlash("discoverPerson", Yii::t('msg','To see all events please login or {register}',array('{register}'=>$register)), "alert", false);
    }*/
    $this->render("calendar",array("events"=>$events));
  }
  
  /**
   * apply for events
   */
  public function actionApplyForEvent($event){
    if (!Yii::app()->user->isGuest){
      

      if(isset($_POST['Event'])) {
        if (!isset($_POST['Event']['present']) || !isset($_POST['Event']['cofounder'])){
          setFlash ('fields_problem', Yii::t('msg','Please fill all fields!'), 'alert');
        }else{
          $userTag = UserTag::model()->findByAttributes(array("user_id"=>Yii::app()->user->id,"tag"=>$event));
          if (!$userTag){
            $userTag = new UserTag();
            $userTag->user_id = Yii::app()->user->id;
            $userTag->tag = $event;

            $userTag->content = $_POST['Event']['present']." is cofounder ".$_POST['Event']['cofounder'];
            $userTag->save();


            $message = new YiiMailMessage;
            $message->view = 'system';
            $message->subject = "Nov uporabnik (".Yii::app()->user->fullname.") prijavljen na dogodek ".$event;
            // nam sporočilo o registraciji z mailom
            $message->setBody(array("content"=>'Uporabnik '.Yii::app()->user->fullname.' se je pravkar prijavil na dogodek.<br /><br />'.$userTag->content.'<br />
                                        Njegov email: '.Yii::app()->user->email.'<br />'.
                                        'Rad bi: '.$_POST['Event']['present'].'<br />'.
                                        'Je že kdaj bil ustanovitelj: '.$_POST['Event']['cofounder'].'<br /><br />'.
                                        'Njegov profil na Cofinderju si lahko ogledate <a href="'.$this->createAbsoluteUrl("/person/view",array("id"=>Yii::app()->user->id)).'">tukaj</a>'), 'text/html');
            $message->setTo("cofinder@hekovnik.si");
            $message->from = Yii::app()->params['noreplyEmail'];
            Yii::app()->mail->send($message);
          }
          $this->render('message',array('title'=>Yii::t('msg','Thank you for applying to this event'),
                                        'content'=>Yii::t('msg','We need to confirm your application and will get back to you with further instructions.')));
          return;
        }
      }
      
      $this->render("event");
      return;
      
    }else{
      $this->redirect(array("/user/registration","event"=>$event));
      return;
    }
  }
  
  public function actionVote(){
     $this->render('message',array('title'=>Yii::t('msg','Thank you for voting'),
                                    'content'=>Yii::t('app','Go to ').'<a href="http://www.cofinder.eu">Cofinder</a>'));
  }
  
  /**
   * 
   */
  public function actionClearNotif($type){
    Notifications::viewNotification($type);
  }
  
  
  /**
   * assign everyone a vanity url
   */
  public function actionSetVanityUrl(){
    $users = User::model()->findAll(array('order'=>'status DESC'));
    
    foreach ($users as $user){
      if ($user->vanityURL == ''){
        $i = 0;
        while ($i < 1000){
          $user->vanityURL = str_replace(" ", "", strtolower($user->name."-".$user->surname));
          if ($i > 0) $user->vanityURL .= "-".$i;
          $i++;
          if (Idea::model()->findByAttributes(array('vanityURL'=>$user->vanityURL))) continue;
          if ($user->save()) break;
        }
      }
    }
     $this->render('message',array('title'=>"Fill vanity urls",'content'=>"Success!"));
  }

  /**
   * Sql Script for Skill -> Industry (delete later)
   */
  public function actionSqlIndustry(){

  	//foreach user copy USER_SKILL . SKILLSET_ID to USER_INDUSTRY . INDUSTRY_ID

  		$sql = "SELECT * FROM user_skill GROUP BY skillset_id, match_id";
  		
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();

		while(($row=$dataReader->read())!==false) {
			$userindustry = New UserIndustry();
			$userindustry->match_id = $row['match_id'];
			$userindustry->industry_id = $row['skillset_id'];
			$userindustry->save();
		}

	//count skill in user_skill and assign count

		$sql = "SELECT skill_id, count(skill_id) as count FROM `user_skill` GROUP BY skill_id";
  		
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();

		while(($row=$dataReader->read())!==false) {
			$skill = Skill::model()->findByAttributes(array('id'=>$row['skill_id']));
			$skill->count = $row['count'];
			$skill->save();
		}

	//count industry in user_industry and assign count
		$sql = "SELECT industry_id, count(industry_id) as count FROM `user_industry` GROUP BY industry_id";
  		
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();

		while(($row=$dataReader->read())!==false) {
			$industry = Industry::model()->findByAttributes(array('id'=>$row['industry_id']));
			$industry->count = $row['count'];
			$industry->save();
		}
		
  }
	
}
