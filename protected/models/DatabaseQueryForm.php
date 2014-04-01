<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class DatabaseQueryForm extends CFormModel
{
	public $sql;
	public $rawData = true;
	public $graph;
	public $title;
	public $x;
	public $y;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('sql', 'required'),
      array('graph, title, x, y, rawData', 'safe'),
			// verifyCode needs to be entered correctly
			//array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}
  
  public function validateSql($attribute, $params){
    
    if(!$this->hasErrors()){
			if ((stripos($this->sql, "delete ") === false) && (stripos($this->sql, "update ") === false)) return true;
		}
    
    return false;
  }

  /**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'sql'=>'SQL',
			'graph'=>'Graph style',
		);
	}
}