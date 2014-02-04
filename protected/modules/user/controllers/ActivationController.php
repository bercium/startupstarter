<?php

class ActivationController extends Controller
{
	public $defaultAction = 'activation';
  public $layout = "//layouts/card";
	
	/**
	 * Activation user account
	 */
	public function actionActivation () {
		$email = $_GET['email'];
		$activkey = $_GET['activkey'];
		if ($email&&$activkey) {
			$find = User::model()->findByAttributes(array('email'=>$email));
			if (isset($find)&&$find->status) {
          if (Yii::app()->user->isGuest) $this->render('/user/message',array('title'=>Yii::t('app',"User activation"),'content'=>Yii::t('msg',"You account is already active.").'<br /><br /><a href="#" data-dropdown="drop-login" class="button radius small" >'.Yii::t('app','Login now').'</a>' ));
          else {
            $this->redirect(Yii::app()->createUrl("site/index"));
            die();
          }
			} elseif(isset($find->activkey) && ($find->activkey==$activkey)) {
				$find->activkey = UserModule::encrypting(microtime());
				$find->status = 1;
				if ($find->save()){
          $this->render('/user/message',array('title'=>Yii::t('app',"User activation"),
                                          'content'=>Yii::t('msg',"You account is activated.").'<br /><br /><a href="#" data-dropdown="drop-login" class="button radius small" >'.Yii::t('app','Login now').'</a>'));
          
          // send notification
          $message = new YiiMailMessage;
          $message->view = 'system';
          $message->setBody(array("content"=>"You account on Cofinder has been approved. You can now <a href='http://www.cofinder.eu'>login</a>"), 'text/html');
          $message->subject = 'Cofinder account approved';
          $message->addTo($find->email);
          $message->from = Yii::app()->params['noreplyEmail'];
          Yii::app()->mail->send($message);          
          
        }else{ $this->render('/user/message',array('title'=>Yii::t('app',"User activation"),
                                          'content'=>Yii::t('msg',"There was a problem activating your account!") ));
            //.print_r($find,true).print_r($find->getErrors(),true)
        }
			} else {
			    $this->render('/user/message',array('title'=>Yii::t('app',"User activation"),'content'=>Yii::t('msg',"Incorrect activation URL.")));
			}
		} else {
			$this->render('/user/message',array('title'=>Yii::t('app',"User activation"),'content'=>Yii::t('msg',"Incorrect activation URL.")));
		}
	}

}