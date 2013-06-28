<?php

class RegistrationController extends Controller
{
	public $defaultAction = 'registration';
  public $layout = "//layouts/card";
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}
	/**
	 * Registration user
	 */
	public function actionRegistration($id = '') {
        //Profile::$regMode = true;
        $model = new RegistrationForm;
        //$profile=new Profile;

        // ajax validator
        /*if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
        {
            echo UActiveForm::validate(array($model));
            Yii::app()->end();
        }*/
        
        if (Yii::app()->user->id) {
            $this->redirect(Yii::app()->createUrl('profile'));
        } else {
            $invited = null;
            if ($id != '') $invited = Invite::model()->findByAttributes(array('key' => "a4"));
            
            if ($id == '' || $invited == null) {
              Yii::log(CVarDumper::dumpAsString($invited));
              /*print_r($invited." - ".$id);*/
              //$this->render('/user/registration',array('model'=>$model));//*/
              $this->redirect(Yii::app()->createUrl('site/notify'));
            }
            else{
              
              
              if(isset($_POST['RegistrationForm'])) {
                  $model->attributes=$_POST['RegistrationForm'];
                  //$profile->attributes=((isset($_POST['Profile'])?$_POST['Profile']:array()));
                  if($model->validate()/*&&$profile->validate()*/)
                  {
                      $soucePassword = $model->password;
                      $model->activkey=UserModule::encrypting(microtime().$model->password);
                      $model->password=UserModule::encrypting($model->password);
                      $model->verifyPassword=UserModule::encrypting($model->verifyPassword);
                      $model->superuser=0;
                      $model->status=((Yii::app()->controller->module->activeAfterRegister)?User::STATUS_ACTIVE:User::STATUS_NOACTIVE);

                      if ($model->save()) {
                          //$profile->user_id=$model->id;
                          //$profile->save();
                        $activation_url = '<a href="'.$this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $model->activkey, "email" => $model->email)).">".Yii::t('msg',"Activate")."</a>";
                        
                        $message = new YiiMailMessage;
                        $message->view = 'system';
                        $message->setBody(Yii::t('msg',"To activate you account go to {activation_url}",array('{activation_url}'=>$activation_url)), 'text/html');
                        $message->subject = Yii::t('msg','Registration for coFinder');
                        $message->addTo($model->email);
                        $message->from = Yii::app()->params['noreplyEmail'];
                        Yii::app()->mail->send($message);

                          /*if (Yii::app()->controller->module->sendActivationMail) {
                               $activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $model->activkey, "email" => $model->email));
                              UserModule::sendMail($model->email,Yii::t('msg',"You registered from {site_name}",array('{site_name}'=>Yii::app()->name)),Yii::t('msg',"Please activate you account go to {activation_url}",array('{activation_url}'=>$activation_url)));
                          }*/
                          /*
                          if ((Yii::app()->controller->module->loginNotActiv||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin) {
                                  $identity=new UserIdentity($model->email,$soucePassword);
                                  $identity->authenticate();
                                  Yii::app()->user->login($identity,0);
                                  $this->redirect(Yii::app()->controller->module->returnUrl);
                          } else {
                              if (!Yii::app()->controller->module->activeAfterRegister&&!Yii::app()->controller->module->sendActivationMail) {
                                  Yii::app()->user->setFlash('registration',Yii::t('msg',"Thank you for your registration. Contact Admin to activate your account."));
                              } elseif(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false) {
                                  Yii::app()->user->setFlash('registration',Yii::t('msg',"Thank you for your registration. Please {{login}}.",array('{{login}}'=>CHtml::link(Yii::t('app','Login'),Yii::app()->controller->module->loginUrl))));
                              } elseif(Yii::app()->controller->module->loginNotActiv) {
                                  Yii::app()->user->setFlash('registration',Yii::t('msg',"Thank you for your registration. Please check your email or login."));
                              } else {
                                  Yii::app()->user->setFlash('registration',Yii::t('msg',"Thank you for your registration. Please check your email."));
                              }
                              $this->refresh();
                          }*/
                      }
                  } /*else $profile->validate();*/
              }

              $this->render('/user/registration',array('model'=>$model));
            }
        }
	}
}