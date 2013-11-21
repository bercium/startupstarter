<?php

class NewsletterController extends GxController {

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
			array('allow', // allow admins only
				'users'=>Yii::app()->getModule('user')->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
  
  /**
   * Show form for writing a newsletter and sending it to all subscribers
   */
  public function actionIndex(){
		$model=new NewsletterForm;
		if(isset($_POST['NewsletterForm'])){
			$model->attributes=$_POST['NewsletterForm'];
			if($model->validate()){
        
        $message = new YiiMailMessage;
        $message->view = 'newsletter';
        $message->subject = $model->newsletterTitle;
        $message->from = Yii::app()->params['adminEmail'];
        
        // send to specific emails
        if ($model->newsletterEmails){
          $users = explode(",", $model->newsletterEmails);
          foreach ($users as $user){
            $message->setBody(array("content"=>$model->newsletter), 'text/html');
            $message->setTo(trim($user));
            Yii::app()->mail->send($message);
          }
        }else{
          // get all users with newsletter on
          $users = User::model()->findAllByAttributes(array('newsletter'=>'1'));
          foreach ($users as $user){
            $message->setBody(array("content"=>$model->newsletter,"activkey"=>$user->activkey), 'text/html');
            $message->setTo($user->email);
            Yii::app()->mail->send($message);
          }

          // send newsletter to all in waiting list
          $invites = Invite::model()->findAll();
          foreach ($invites as $user){
            $message->setBody(array("content"=>$model->newsletter,"email"=>$user->email), 'text/html');
            $message->setTo($user->email);
            Yii::app()->mail->send($message);
          }
        }
        
				setFlash('newsletter',Yii::t('msg',"Newsletter sent succesfully."));
        $this->refresh();
			}
		}
		$this->render('index',array('model'=>$model));
    
    //print_r($_POST);
    /*if(isset($_POST['IndexForm'])) {
        // collects user input data
        $model->attributes=$_POST['LoginForm'];
        // validates user input and redirect to previous page if validated
        if($model->validate())
            $this->redirect(Yii::app()->user->returnUrl);
    }*/
    //$this->render('index', array(		));
  }

	public function actionTestSend() {
    
    $message = new YiiMailMessage;
    $message->view = 'newsletter';
    $message->setBody(array("content"=>'En testni mail'), 'text/html');
    $message->subject = 'Testni subjekt';
    $message->addTo('bercium@gmail.com');
    $message->from = app()->params['noreplyEmail'];
    Yii::app()->mail->send($message);
    
    //echo "OK";
	}
  
	public function actionMailSystem() {
    Yii::app()->clientScript->reset();
    $this->layout = 'blank';
    $content = '<strong>HERE GOES CONTENT</strong> (write your test content in URL "content" parameter)';
    if (isset($_GET['content'])) $content = $_GET['content'];
    $this->render('//layouts/mail/system',array('content'=>$content));
  }

	public function actionMailNews(){
    Yii::app()->clientScript->reset();
    $this->layout = 'blank';
    $content = '<strong>HERE GOES CONTENT</strong> (write your test content in URL "content" parameter)';
    if (isset($_GET['content'])) $content = $_GET['content'];
    $this->render('//layouts/mail/newsletter',array('content'=>$content));
  }
  
}
