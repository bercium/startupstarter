<?php

Yii::import('application.models._base.BaseTranslation');

class Translation extends BaseTranslation
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}