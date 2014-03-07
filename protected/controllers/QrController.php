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
    
    // code has expired
    $td = timeDifference(time(), $qr->create_at,'minutes_total');
    if ($td >= 5){
      echo false;
      return;
    }
    
    // check code
    if ($qr && $qr->user_id){
      $identity=new UserIdentity($qr->user->email,$qr->user->password);
      $identity->qrcode = true;
      if ($identity->authenticate()) Yii::app()->user->login($identity);
      
      $this->log('validate',$qr->user_id);
      
      $qr->delete(); // one time use
      echo true;
    }else echo false;
    Yii::app()->end();
	}

	public function actionScan($id) {
    $qr = QrLogin::model()->findByPk($id);
    
    if (!$qr || $qr->user_id){
      $this->render('//site/message',array("title"=>Yii::t('msg','Problem scaning code'),"content"=>Yii::t('msg','Something went wrong while scaning the code!<br /> Please refresh the page and rescan the code.')));
      return;
    }

    $this->log('scan');

    // check validity of token (5min)
    $td = timeDifference(time(), $qr->create_at,'minutes_total');
    if ($td < 5){
      if ($qr->user_id == null && $qr->scan_at == null){
        $qr->scan_at = date('Y-m-d H:i:s');
        $qr->save();
      }
      
      // has cookie auto login
      if (Yii::app()->request->cookies->contains('mblg')){
        $code = Yii::app()->request->cookies['mblg']->value;
        $usr = User::model()->findByAttributes(array('qrcode'=>$code));
        
        if ($usr){
          $qr->user_id = $usr->id;
          $qr->save();
          // user found
          $this->render('//site/message',array('title'=>Yii::t('msg','Loged in'),"content"=>Yii::t('msg','You should be loged in shortly.')));
        }else{
          // no user
          unset(Yii::app()->request->cookies['mblg']);
          $this->render('//site/message',array("title"=>Yii::t('msg','Problem scaning code'),"content"=>Yii::t('msg','sssSomething went wrong while scaning the code!<br /> Please refresh the page and rescan the code.')));
        }
        return;
      }
     
      // go to login form and login from phone
      $this->redirect(Yii::app()->createUrl("qr/login",array("id"=>$id)));
    }
    else{
      $this->render('//site/message',array('title'=>Yii::t('msg','Code expired'),"content"=>Yii::t('msg','The code has expired!<br /> Please refresh the page and rescan the code.')));
      return;
    }
    
    
  }
  
  
	public function actionLogin($id) {
    $qr = QrLogin::model()->findByPk($id);
    if (!$qr || $qr->user_id){
      $this->render('//site/message',array("title"=>Yii::t('msg','Problem scaning code'),"content"=>Yii::t('msg','Something went wrong while scaning the code!<br /> Please refresh the page and rescan the code.')));
      return;
    }
    // check validity of token (5min)
    $td = timeDifference(time(), $qr->create_at,'minutes_total');
    if ($td >= 5){
      $this->render('//site/message',array('title'=>Yii::t('msg','Code expired'),"content"=>Yii::t('msg','The code has expired!<br /> Please refresh the page and rescan the code.')));
      return;
    }
    
    $model=new LoginForm();
    
    if(isset($_POST['LoginForm'])){
      $model->attributes=$_POST['LoginForm'];
      $model->rememberMe = false;
      // validate user input and redirect to previous page if valid
      if($model->validate()) {
        $identity = new UserIdentity($model->username,$model->password);
        if ($identity->authenticate()){
          $user = User::model()->findByAttributes(array('email'=>$model->username));
          
          $code = UserModule::encrypting(microtime().$model->username);
          $user->qrcode = $code; //set code
          $user->save();
          
          $qr->user_id = $user->id;
          $qr->save();
          
          Yii::app()->request->cookies['mblg'] = new CHttpCookie('mblg', $code, 
                            array(//'domain'=>'.cofinder.eu',
                                  'expire'=>time()+60*60*24*30*12,  //1 year
                                  //'secure'=>'',
                                  'httpOnly'=>true
                            ));
          $this->render('//site/message',array('title'=>Yii::t('msg','Loged in'),"content"=>Yii::t('msg','You should be loged in shortly.')));
          return;
        }
      }
      
    }
    
    $this->render('login',array("model"=>$model));
	}
  
  
  private function log($action, $user_id = null){
    $log = new ActionLog();
    $log->action = $action;
    $log->controller = 'qr';
    $log->ipaddress = $_SERVER['REMOTE_ADDR'];
    $log->user_id = $user_id;
    $log->logtime = date("Y-m-d H:i:s");
    $log->save();
  }
  
}
