<?php

Yii::import('application.models._base.BaseCities');

class Cities extends BaseCities
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}