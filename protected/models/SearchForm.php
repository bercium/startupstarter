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
	public $country;
	public $city;
	public $skill;
	public $skillSet;
	
	public $stage;
	public $keywords;
	public $extraDetail;
	public $content;
	public $language;
  
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
		  array('isProject, collabPref, available, country, city, skill, skillSet, stage, keywords, language','safe'),
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

}
