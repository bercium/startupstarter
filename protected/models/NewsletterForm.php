<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class NewsletterForm extends CFormModel
{
	public $newsletter;
	public $newsletterTitle;
	public $newsletterEmails;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('newsletter, newsletterTitle', 'required'),
      array('newsletterEmails', 'safe'),
			// verifyCode needs to be entered correctly
			//array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
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
			'newsletter'=>Yii::t('app', 'Newsletter'),
			'newsletterTitle'=>Yii::t('app', 'Newsletter title'),
			'newsletterEmails'=>Yii::t('app', 'Newsletter emails'),
		);
	}
}