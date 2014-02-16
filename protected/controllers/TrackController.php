<?php

class TrackController extends Controller
{
  public $layout="//layouts/blank";
  
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
        'actions'=>array('mailOpen','ml'),
				'users'=>array('*'),
			),
			/*array('allow', // allow authenticated user to perform 'create' and 'update' actions
        'actions'=>array(),
				'users'=>array('@'),
			),*/
			array('allow', // allow admin user to perform actions:
				'actions'=>array('index'),
				'users'=>Yii::app()->getModule('user')->getAdmins(),
			),
			/*array('deny',  // deny all users
				'users'=>array('*'),
			),*/
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
  
  protected function beforeAction($action){
    if ($action->id != 'index'){
      foreach (Yii::app()->log->routes as $route){
        //if ($route instanceof CWebLogRoute){
          $route->enabled = false;
        //}
      }
      Yii::app()->clientScript->reset();
    }
    return true;
  }
  
  protected function afterAction($action){
    if ($action->id == 'index') return true;
    header('Content-Type: image/jpeg');
    echo file_get_contents("images/px.png");
    Yii::app()->end();
  }

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex($id = 1){
    $this->layout = 'card';
    //$this->render('index');
 	}
  
	/**
	 * track message openers
	 */
	public function actionMailOpen($tc){
    /*Yii::import('application.helpers.Hashids');
    $hashids = new Hashids('cofinder');
    $tid = $hashids->decrypt($id);
    $id = $tid[0];*/
    $tc = mailTrackingCodeDecode($tc);
    
    $openedMail = MailLog::model()->findByAttributes(array("tracking_code"=>$tc));
    if ($openedMail){
      $openedMail->time_open = date('Y-m-d H:i:s');
      $openedMail->save();
      // mark message as read
      if ($openedMail->type == 'user-message'){
        $message_read = Message::model()->findByPk($openedMail->extra_id);
        if ($message_read){
          $message_read->time_viewed =  date('Y-m-d H:i:s');
          $message_read->save();
        }
      }
    }
    
 	}
  

  
  /**
   * tracking mail link clicks
   */
  public function actionMl($tc, $l, $ln) {
    /*Yii::import('application.helpers.Hashids');
    $hashids = new Hashids('cofinder');
    $tid = $hashids->decrypt($id);
    $id = $tid[0];*/
    $tc = mailTrackingCodeDecode($tc);
    
    $mailLinkClick = new MailClickLog();
    $mailLinkClick->link = $l;
    $mailLinkClick->mail_tracking_code = $tc;
    $mailLinkClick->time_clicked = date('Y-m-d H:i:s');
    $mailLinkClick->button_name = $ln;
    $mailLinkClick->save();
    
    $this->redirect($l);
    Yii::app()->end();
  }
	
}
