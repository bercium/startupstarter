<?php

class QrController extends Controller
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
  
	public function actionCreate() {
    $qr = new QrLogin();
    $qr->save();
    echo $qr->id;
    Yii::app()->end();
	}
  
	public function actionValidate($id) {
    $qr = QrLogin::model()->findByPk($id);
    if ($qr && $qr->user_id) echo true;
    echo false;
    Yii::app()->end();
	}

	public function actionScan($id) {
    $qr = QrLogin::model()->findByPk($id);
    
    if (!$qr || $qr->user_id){
      $this->render('//site/message',array("title"=>Yii::t('msg','Problem scaning code'),"content"=>Yii::t('msg','Something went wrong while scaning the code!<br /> Please refresh the page and rescan the code.')));
      return;
    }
    
    // check validity of token (5min)
    $td = timeDifference(time(), $qr->create_at,'minutes_total');
    if ($td < 5){
      if ($qr->user_id == null && $qr->scan_at == null){
        $qr->scan_at = date('Y-m-d H:i:s');
        $qr->save();
      }
      
      // has cookie auto login
      if (Yii::app()->request->cookies->contains('mblg')){
        $key = Yii::app()->request->cookies['mblg']->value;
        $usr = User::model()->findByAttributes(array(''=>$key));
        
        if ($usr){
          // user found
          $this->render('//site/message',array('title'=>Yii::t('msg','Loged in'),"content"=>Yii::t('msg','You should be loged in shortly.')));
        }else{
          // no user
          unset(Yii::app()->request->cookies['mblg']);
          $this->render('//site/message',array("title"=>Yii::t('msg','Problem scaning code'),"content"=>Yii::t('msg','Something went wrong while scaning the code!<br /> Please refresh the page and rescan the code.')));
        }
        return;
      }
     
      // go to login form and login from phone
      $this->redirect("/qr/login",array("id"=>$id));
    }
    else{
      $this->render('//site/message',array('title'=>Yii::t('msg','Code expired'),"content"=>Yii::t('msg','The code has expired!<br /> Please refresh the page and rescan the code.')));
      return;
    }
    
    
  }
  
	public function actionLogin($id) {
    //$this->actionIndex($id, $group);
	}
  
}
