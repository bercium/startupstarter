<?php

Yii::import('application.models._base.BaseClickUser');

class ClickUser extends BaseClickUser
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}