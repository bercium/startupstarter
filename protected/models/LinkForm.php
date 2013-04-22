<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class LinkForm extends CFormModel
{
	public $linkName;
	public $link;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('linkName, link', 'required'),
			// email has to be a valid email address
			array('link', 'url'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'linkName'=>Yii::t('app','Name of link'),
			'link'=>Yii::t('app','URL link'),
		);
	}
}