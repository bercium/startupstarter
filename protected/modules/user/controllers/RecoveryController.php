<?php

class RecoveryController extends Controller
{
	public $defaultAction = 'recovery';
  public $layout = "//layouts/card";	
  
	/**
	 * Recovery password
	 */
	public function actionRecovery () {
		$form = new UserRecoveryForm;
		if (Yii::app()->user->id) {
		    	$this->redirect(Yii::app()->controller->module->returnUrl);
		    } else {
				$email = ((isset($_GET['email']))?$_GET['email']:'');
				$activkey = ((isset($_GET['activkey']))?$_GET['activkey']:'');
				if ($email&&$activkey) {
					$form2 = new UserChangePassword;
		    		$find = User::model()->notsafe()->findByAttributes(array('email'=>$email));
		    		if(isset($find)&&$find->activkey==$activkey) {
			    		if(isset($_POST['UserChangePassword'])) {
							$form2->attributes=$_POST['UserChangePassword'];
							if($form2->validate()) {
								$find->password = Yii::app()->controller->module->encrypting($form2->password);
								$find->activkey=Yii::app()->controller->module->encrypting(microtime().$form2->password);
								if ($find->status==0) {
									$find->status = 1;
								}
								$find->save();
								Yii::app()->user->setFlash('recoveryMessage',Yii::t('msg',"New password is saved.".'<br /><br /><a href="#" data-dropdown="drop-login" class="button radius small" >'.Yii::t('app','Login now').'</a>'));
								$this->redirect(Yii::app()->controller->module->recoveryUrl);
							}
						} 
						$this->render('changepassword',array('form'=>$form2));
		    		} else {
		    			Yii::app()->user->setFlash('recoveryMessage',Yii::t('msg',"Incorrect recovery link."));
						$this->redirect(Yii::app()->controller->module->recoveryUrl);
		    		}
		    	} else {
			    	if(isset($_POST['UserRecoveryForm'])) {
			    		$form->attributes=$_POST['UserRecoveryForm'];
			    		if($form->validate()) {
			    			$user = User::model()->notsafe()->findbyPk($form->user_id);
							//$activation_url = 'http://' . $_SERVER['HTTP_HOST'].$this->createUrl(implode(Yii::app()->controller->module->recoveryUrl),array("activkey" => $user->activkey, "email" => $user->email));
              
              $activation_url = '<a href="'.$this->createAbsoluteUrl('/user/recovery',array("activkey" => $user->activkey, "email" => $user->email)).'">'.Yii::t('app',"Activate")."</a>";
							
							$subject = "Password recovery for cofinder";
			    		$message1 = 'You have requested the password recovery for <a href="www.cofinder.eu">cofinder</a>. To receive a new password, go to '.$activation_url;
              
                $message = new YiiMailMessage;
                $message->view = 'system';
                $message->setBody(array("content"=>$message1), 'text/html');
                $message->subject = $subject;
                $message->addTo($user->email);
                $message->from = Yii::app()->params['noreplyEmail'];
                Yii::app()->mail->send($message);
                
                
			    			//UserModule::sendMail($user->email,$subject,$message);
  							Yii::app()->user->setFlash('recoveryMessage',Yii::t('msg'," Please check your email. <br />Instructions were sent to your email address."));
			    			$this->refresh();
			    		}
			    	}
		    		$this->render('recovery',array('form'=>$form));
		    	}
		    }
	}

}