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
			$find = User::model()->notsafe()->findByAttributes(array('email'=>$email));
			if (isset($find)&&$find->status) {
			    $this->render('/user/message',array('title'=>Yii::t('app',"User activation"),'content'=>Yii::t('msg',"You account is allready active.")));
			} elseif(isset($find->activkey) && ($find->activkey==$activkey)) {
				$find->activkey = UserModule::encrypting(microtime());
				$find->status = 1;
				if ($find->save())  $this->render('/user/message',array('title'=>Yii::t('app',"User activation"),
                                          'content'=>Yii::t('msg',"You account is activated.").'<br /><br /><a href="#" data-dropdown="drop-login" class="button radius small" >'.Yii::t('app','Login now').'</a>'));
        else $this->render('/user/message',array('title'=>Yii::t('app',"User activation"),
                                          'content'=>Yii::t('msg',"There was a problem activating your account!")));
			} else {
			    $this->render('/user/message',array('title'=>Yii::t('app',"User activation"),'content'=>Yii::t('msg',"Incorrect activation URL.")));
			}
		} else {
			$this->render('/user/message',array('title'=>Yii::t('app',"User activation"),'content'=>Yii::t('msg',"Incorrect activation URL.")));
		}
	}

}