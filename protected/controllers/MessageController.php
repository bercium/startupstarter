<?php

class MessageController extends Controller
{

	public $layout="//layouts/edit";

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
        'actions'=>array("contact"),
				'users'=>array('@'),
			),
			array('allow', // allow admins only
				'users'=>Yii::app()->getModule('user')->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
  
  
	public function actionView()
	{
		$this->render('view');
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
      setFlash('contactPerson', Yii::t("msg","Your message was sent."));
    }else{
      setFlash('contactPerson', Yii::t("msg","Message can't be empty!"), 'alert');
    }
    
    goBackController();
    //$this->refresh();
    //$this->redirect(Yii::app()->createUrl("person/view",array("id"=>$id)));
	}  

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}