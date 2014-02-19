<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class SearchForm extends CFormModel
{
  public $isProject = true;
	
	public $collabPref;
	public $available;
	public $city;
	public $skill;
	public $user;
	public $stage;
  
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			//array('username, password', 'required'),
			// rememberMe needs to be a boolean
			//array('rememberMe', 'boolean'),
			// password needs to be authenticated
			//array('password', 'authenticate'),
		  array('isProject, collabPref, available, city, skill, stage, user','safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
		);
	}
	
	public function checkSearchForm(){
		return (!empty($this->available)) ||
					 (!empty($this->city)) ||
					 (!empty($this->collabPref)) ||
					 (!empty($this->stage)) ||
					 (!empty($this->user)) ||
					 (!empty($this->skill));
	}

	public function checkAdvanceForm(){
		if ($this->isProject){
			return (!empty($this->available)) ||
						 (!empty($this->city)) ||
						 (!empty($this->collabPref)) ||
						 (!empty($this->skill));
		}else{
			return (!empty($this->city)) ||
						 (!empty($this->skill));
		}
	}

}
