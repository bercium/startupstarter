<?php

class MailerCommand extends CConsoleCommand{

  
  /**
   * generates weekly reports for users that want them
   */
	public function actionWeekly(){
    return 0;
    
    $message = new YiiMailMessage;
    //$message->view = 'newsletter';
    $message->setBody('En testni mail', 'text/html');
    $message->subject = "subject";

    // get all users
    $criteria = new CDbCriteria();
    $criteria->condition = 'newsletter=1'; // new
    $users = User::model()->findAll($criteria);
    foreach ($users as $user){
      $message->addBcc($user->email);
    }

    $message->from = Yii::app()->params['adminEmail'];
    Yii::app()->mail->send($message);
    
    //return 0; // all OK // not needed
	}
  
  /**
   * generates monthly reports for users that want them
   */
	public function actionMonthly(){
    return 0;
    
    $message = new YiiMailMessage;
    //$message->view = 'newsletter';
    $message->setBody('En testni mail', 'text/html');
    $message->subject = "subject";

    // get all users
    $criteria = new CDbCriteria();
    $criteria->condition = 'newsletter=1'; // new
    $users = User::model()->findAll($criteria);
    foreach ($users as $user){
      $message->addBcc($user->email);
    }

    $message->from = Yii::app()->params['adminEmail'];
    Yii::app()->mail->send($message);
	}
}