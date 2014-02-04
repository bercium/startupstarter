<?php
/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user registration form data. It is used by the 'registration' action of 'UserController'.
 */
class RegistrationForm extends User {
	public $verifyPassword;
	public $verifyCode;
  public $tos;
	
	public function rules() {
		$rules = array(
			array('password, email, name, ', 'required'),
      //array('password, verifyPassword, email, name, ', 'required'),       
      array('tos', 'compare', 'compareValue' => true, 
            'message' => Yii::t('msg','You must agree to the terms and conditions' )),
			array('surname', 'safe'),
			//array('username', 'length', 'max'=>20, 'min' => 3,'message' => Yii::t('msg',"Incorrect username (length between 3 and 20 characters).")),
			array('password', 'length', 'max'=>128, 'min' => 6,'message' => Yii::t('msg',"Incorrect password (minimal length 6 symbols).")),
			array('email', 'email'),
			//array('username', 'unique', 'message' => Yii::t('msg',"This user's name already exists.")),
			array('email', 'unique', 'message' => Yii::t('msg',"This user's email address already exists.")),
			//array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => Yii::t('msg',"Retype password is incorrect.")),
			//array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => Yii::t('msg',"Incorrect symbols (A-z0-9).")),
		);
		if (!(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')) {
			array_push($rules,array('verifyCode', 'captcha', 'allowEmpty'=>!UserModule::doCaptcha('registration')));
		}
		
		return $rules;
	}
  
	
}