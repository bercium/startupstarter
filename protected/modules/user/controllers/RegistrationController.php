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
        $event = null;
        if (isset($_GET['event'])){
          Yii::app()->session['event'] = $_GET['event'];
          $event = Event::model()->findByPk($_GET['event']);
        }
        
        if (Yii::app()->user->id) {
          if (isset($_GET['event'])){
            $this->redirect(Yii::app()->createUrl('event/signup',array("id"=>Yii::app()->session['event'])));
            Yii::app()->end();
          }

          $this->redirect(Yii::app()->createUrl('profile'));
          Yii::app()->end();
        } else {
            $invited = null;
            if ($id != ''){
              $invited = Invite::model()->findByAttributes(array('key' => $id,'idea_id'=>null));
              $model->email = $invited->email;
            }

            if(isset($_POST['RegistrationForm'])) {
                $model->attributes=$_POST['RegistrationForm'];
                //$profile->attributes=((isset($_POST['Profile'])?$_POST['Profile']:array()));
                
                if($model->validate()/*&&$profile->validate()*/)
                {
                    $soucePassword = $model->password;
                    $model->password=UserModule::createHash($model->password);
                    $model->activkey=UserModule::encrypting(microtime().$model->password);
                    $model->verifyPassword=$model->password;
                    $model->superuser=0; //not admin
                    $model->status=(($invited || ($event)) ? User::STATUS_ACTIVE:User::STATUS_NOACTIVE);
                    $model->name = trim($model->name);
                    $model->surname = trim($model->surname);
                    

                    if ($model->save()) {
                      $user_match = new UserMatch();
                      $user_match->user_id = $model->id;
                      $user_match->save();
                      
                      // auo create vanity url
                      $i = 0;
                      $user = UserEdit::model()->findByPk($model->id);
                      while ($i < 1000){
                        $user->vanityURL = str_replace(" ", "-", strtolower(trim($user->name)."-".trim($user->surname)));
                        if ($i > 0) $user->vanityURL .= "-".$i;
                        $i++;
                        if (Idea::model()->findByAttributes(array('vanityURL'=>$user->vanityURL))) continue;
                        if ($user->save()){
                          break;
                        }
                      }
                      
                      //completeness
                      $com = new Completeness();
                      $com->setPercentage($model->id);
                      
                      $activation_url = '<a href="'.$this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $model->activkey, "email" => $model->email)).'">Activate</a>';

                      $fix_url = Yii::app()->createAbsoluteUrl("/profile/registrationFlow",array("key"=>substr($model->activkey,0, 10),"email"=>$model->email));
                      // if invitation set
                      if ($id == '' || $invited == null) {
                        //notify us
                        $message = new YiiMailMessage;
                        $message->view = 'system';
                        $message->subject = 'New user registered ('.$model->name." ".$model->surname.')';
                        $message->setBody(array("content"=>"To check his profile go to ".$this->createAbsoluteUrl("/person/view",array("id"=>$model->id)).
                                                "<br /><br />".
                                                "If something is wrong send him (".$model->email.") this url to fix his profile: ".
                                                $fix_url.
                                                "<br /><br />".
                                                "To activate his account go to ".$activation_url), 'text/html');
                        
                        $message->to = Yii::app()->params['teamEmail'];
                        $message->from = Yii::app()->params['noreplyEmail'];
                        Yii::app()->mail->send($message);
                        
                        $message_notify = new YiiMailMessage;
                        $message_notify->view = 'system';
                        $message_notify->subject = 'Registration for Cofinder';
                        $tc = mailTrackingCode();
                        $ml = new MailLog();
                        $ml->tracking_code = mailTrackingCodeDecode($tc);
                        $ml->type = 'user-register';
                        $ml->user_to_id = $user->id;
                        $ml->save();
                        
                        $message_notify->setBody(array("content"=>"We are really happy you have decided to join our community. "
                                . "We strive to offer high quality profiles and project. "
                                . "This is why we decide on per person basis if we approve your registration or not.<br /><br />"
                                . "Complete your profile information if you haven't done that already ".  mailButton("Fill my profile", $fix_url, 'success', $tc, 'registration-profile-fix')
                                ,"tc"=>$tc), 'text/html');
                        
                        $message_notify->addTo($model->email);
                        $message_notify->from = Yii::app()->params['noreplyEmail'];
                        Yii::app()->mail->send($message_notify);
                        
                        Slack::message("USER >> New user registered: ".$model->email);
                        
                      }else{
                        // if user was invited then allow him to register
                        /*$message = new YiiMailMessage;
                        $message->view = 'system';
                        $message->subject = 'Registration for Cofinder';
                        $tc = mailTrackingCode();
                        $message->setBody(array("content"=>"We are really happy you have decided to join our community. "
                                . "We strive to offer high quality profiles and project. "
                                . "This is why we decide on per person basis if we approve your registration or not.<br /><br />"
                                . "Complete your profile information if you haven't done that already ".  mailButton("Fill my profile", $fix_url, 'success', $tc, 'registration-profile-fix')
                                ,"tc"=>$tc), 'text/html');
                        
                        $message->addTo($model->email);
                        $message->from = Yii::app()->params['noreplyEmail'];
                        Yii::app()->mail->send($message);*/

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

                        // auto login
                        $identity=new UserIdentity($model->email,$soucePassword);
                        $identity->authenticate();
                        Yii::app()->user->login($identity,Yii::app()->controller->module->rememberMeTime);
                        Slack::message("USER >> New invitation registered: ".$model->email);
                      }
                      
                     //mark user but not as member yet
                      //Yii::import('application.helpers.Hashids');
                      $hashids = new Hashids('cofinder');
                      $uid = $hashids->encrypt($model->id);
                      
                      $baseUrl = Yii::app()->baseUrl; 
                      $cs = Yii::app()->getClientScript();
                      $cs->registerScript("ganalyticsregister","ga('send', 'event', 'registration', 'mark_user',{'dimension1':'".$uid."',})");
                      
                      
                        $this->mp->registerOnce("Account Created Date",date("Y-m-d"));
                        $this->mp->registerAll(array("Email"=>$model->email, "Invited"=>($invited != null),'Account Created Date'=>date("Y-m-d") ));
                        $this->mp->people->set($model->email, array(
                            "\$email"=>$model->email,
                            "\$first_name"=>$model->name,
                            "\$last_name"=>$model->surname,
                            "\$name"=>$user->name.' '.$user->surname,
                            "\$created"=>date("Y-m-d"),
                            "Invited"=>($invited != null),
                          ));
                        $this->mp->track("Signup");
                      
                      // MIXPANEL
                      /*Yii::app()->getClientScript()->registerScript("mixpanelregister","mixpanel.register_once({'Account Created Date': '".date("Y-m-d")."'});
                          
                                                                    mixpanel.register({'Email': '".$model->email."',
                                                                    'Account Created Date': '".date("Y-m-d")."',
                                                                    'Invited': '".($invited != null)."'});
                                                                   mixpanel.people.set({'\$email': '".$model->email."',
                                                                    '\$first_name': '".$model->name."',
                                                                    '\$last_name': '".$model->surname."',
                                                                    '\$created': '".date("Y-m-d")."',
                                                                    'Invited': '".($invited != null)."'});
                                                                  mixpanel.track('Signup');
                                                                  mixpanel.alias('".$model->email."');");*/

                      // if someone is coming to an event
                      if (isset($_GET['event'])){
                        // auto login
                        $identity=new UserIdentity($model->email,$soucePassword);
                        $identity->authenticate();
                        Yii::app()->user->login($identity,Yii::app()->controller->module->rememberMeTime);
                        
                        $this->redirect(Yii::app()->createUrl('event/signup',array("id"=>Yii::app()->session['event'])));
                        Yii::app()->end();
                      }else{
                        if ($id == '' || $invited == null){
                            $this->redirect(Yii::app()->createUrl("profile/registrationFlow",array("key"=>substr($model->activkey,0, 10),"email"=>$model->email)));
                            Yii::app()->end();
                        }
                        else{ 
                           $this->render('/user/message',array('title'=>Yii::t('app','Registration finished'),
                            "content"=>Yii::t('msg','Thank you for your registration.')."<br />".
                                      Yii::t('msg','Now fill your profile to become visible.').
                                      '<a href="'.Yii::app()->createUrl("profile/registrationFlow",array()).'" class="button radius success">'.Yii::t('msg','Do it now').'</a>' ));
                          return;
                        }
                      }


                    }else{
                      $model->password = $soucePassword;
                      $model->verifyPassword = $soucePassword;
                    }
                } /*else $profile->validate();*/
            }else{
              $model->tos = true;
            }

            $this->render('/user/registration',array('model'=>$model,'event'=>$event));
            
        }
	}
}
