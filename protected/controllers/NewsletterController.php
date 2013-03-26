<?php

class NewsletterController extends GxController {

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

	public function actionSend() {
    
    $message = new YiiMailMessage;
    $message->view = 'newsletter';
    $message->setBody('En testni mail', 'text/html');
    $message->subject = 'Testni subjekt';
    $message->addTo('bercium@gmail.com');
    $message->from = "bercium@gmail.com";
    Yii::app()->mail->send($message);
    
    echo "OK";
	}

}