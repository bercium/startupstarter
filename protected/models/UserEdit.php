<?php

Yii::import('application.models._base.BaseUserEdit');

class UserEdit extends BaseUserEdit
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}