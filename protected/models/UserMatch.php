<?php

Yii::import('application.models._base.BaseUserMatch');

class UserMatch extends BaseUserMatch
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}