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
            if ($id != '') $invited = Invite::model()->findByAttributes(array('key' => $id,'idea_id'=>null));
            
            if ($id == '' || $invited == null) {
              //Yii::log(CVarDumper::dumpAsString($invited));
              /*print_r($invited." - ".$id);*/
              //$this->render('/user/registration',array('model'=>$model));//*/
              $this->redirect(Yii::app()->createUrl('site/notify'));
            }
            else{
              $model->email = $invited->email;
              
              if(isset($_POST['RegistrationForm'])) {
                  $model->attributes=$_POST['RegistrationForm'];
                  //$profile->attributes=((isset($_POST['Profile'])?$_POST['Profile']:array()));
                  if($model->validate()/*&&$profile->validate()*/)
                  {
                      $soucePassword = $model->password;
                      $model->activkey=UserModule::encrypting(microtime().$model->password);
                      $model->password=UserModule::createHash($model->password);
                      $model->verifyPassword=$model->password;
                      $model->superuser=0;
                      $model->status=((Yii::app()->controller->module->activeAfterRegister)?User::STATUS_ACTIVE:User::STATUS_NOACTIVE);

                      if ($model->save()) {
                        $user_match = new UserMatch();
                        $user_match->user_id = $model->id;
                        $user_match->save();


                    if ($model->save()) {
                      $user_match = new UserMatch();
                      $user_match->user_id = $model->id;
                      $user_match->save();

                      $activation_url = '<a href="'.$this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $model->activkey, "email" => $model->email)).'">Activate</a>';

                      // if invitation set
                      if ($id == '' || $invited == null) {
                        //notify us
                        $message = new YiiMailMessage;
                        $message->view = 'system';
                        $message->subject = 'New user registered';
                        $message->setBody(array("content"=>"To check his profile go to ".$this->createAbsoluteUrl("/person/view",array("id"=>$model->id)).
                                                "<br /><br />".
                                                "If something is wrong send him this url to fix his profile: ".
                                                Yii::app()->createAbsoluteUrl("/profile/registrationFlow",array("key"=>substr($model->activkey,0, 10),"email"=>$model->email)).
                                                "<br /><br />".
                                                "To activate his account go to ".$activation_url), 'text/html');
                        
                        $message = new YiiMailMessage;
                        $message->view = 'system';
                        $message->setBody(array("content"=>"To activate your account go to ".$activation_url), 'text/html');
                        $message->subject = 'Registration for cofinder';
                        $message->addTo($model->email);
                        $message->from = Yii::app()->params['noreplyEmail'];
                        Yii::app()->mail->send($message);
                        
                        
                        //$invited->delete(); // delete invite (depreched)
                        $invited->key = null;
                        $invited->receiver_id = $model->id;
                        $invited->registered = 1;
                        $invited->save();
                        
                        if ($invited->sender_id){
                          // whoever invited user add him a registered bonus
                          $stat = UserStat::model()->findByAttributes(array('user_id'=>$invited->sender_id));
                          $stat->invites_registered = $stat->invites_registered+1;
                          $stat->save();
                        }
                        
                        
                        $this->redirect(Yii::app()->createUrl("profile/registrationFlow",array("key"=>substr($model->activkey,0, 10),"email"=>$model->email)));

                        $this->render('/user/message',array('title'=>Yii::t('app','Registration'),"content"=>Yii::t('msg','Thank you for your registration. Please check your email.')));
                        
                          /*if (Yii::app()->controller->module->sendActivationMail) {
                               $activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $model->activkey, "email" => $model->email));
                              UserModule::sendMail($model->email,Yii::t('msg',"You registered from {site_name}",array('{site_name}'=>Yii::app()->name)),Yii::t('msg',"To activate you account please go to {activation_url}",array('{activation_url}'=>$activation_url)));
                          }*/
                          /*
                          if ((Yii::app()->controller->module->loginNotActiv||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin) {
                                  $identity=new UserIdentity($model->email,$soucePassword);
                                  $identity->authenticate();
                                  Yii::app()->user->login($identity,0);
                                  $this->redirect(Yii::app()->controller->module->returnUrl);
                          } else {
                              if (!Yii::app()->controller->module->activeAfterRegister&&!Yii::app()->controller->module->sendActivationMail) {
                                  setFlash('registration',Yii::t('msg',"Thank you for your registration. Contact Admin to activate your account."));
                              } elseif(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false) {
                                  setFlash('registration',Yii::t('msg',"Thank you for your registration. Please {login}.",array('{login}'=>CHtml::link(Yii::t('app','Login'),Yii::app()->controller->module->loginUrl))));
                              } elseif(Yii::app()->controller->module->loginNotActiv) {
                                  setFlash('registration',Yii::t('msg',"Thank you for your registration. Please check your email or login."));
                              } else {
                                  setFlash('registration',Yii::t('msg',"Thank you for your registration. Please check your email."));
                              }
                              $this->refresh();
                          }*/
                        
                      }else{
                        $model->password = $soucePassword;
                        $model->verifyPassword = $soucePassword;
                      }
                  } /*else $profile->validate();*/
              }

              $this->render('/user/registration',array('model'=>$model));
            }
        }
	}
}
