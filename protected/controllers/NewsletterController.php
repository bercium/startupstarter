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
        $message->setBody($model->newsletter, 'text/html');
        $message->subject = $model->newsletterTitle;
        
        // get all users
        $criteria = new CDbCriteria();
        $criteria->condition = 'newsletter=1';
        $users = User::model()->findAll($criteria);
        foreach ($users as $user){
          $message->addTo($user->email);
        }
        
        $message->from = Yii::app()->params['adminEmail'];
        Yii::app()->mail->batchSend($message);
        
				Yii::app()->user->setFlash('newsletter',Yii::t('msg',"Newsletter sent succersfully."));
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

	public function actionSend() {
    
    $message = new YiiMailMessage;
    $message->view = 'newsletter';
    $message->setBody('En testni mail', 'text/html');
    $message->subject = 'Testni subjekt';
    $message->addTo('bercium@gmail.com');
    $message->from = app()->params['noreplyEmail'];
    Yii::app()->mail->send($message);
    
    //echo "OK";
	}
  
	public function actionMailSystem() {
    $this->layout = 'blank';
    $content = '';
    if (isset($_GET['content'])) $content = $_GET['content'];
    $this->render('//mailTemplates/system',array('content'=>$content));
  }

	public function actionMailNews(){
    $this->layout = 'blank';
    $content = '';
    if (isset($_GET['content'])) $content = $_GET['content'];
    $this->render('//mailTemplates/newsletter',array('content'=>$content));
  }
  
}
