<?php

Yii::import('application.models._base.BaseLanguage');

class Language extends BaseLanguage
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}