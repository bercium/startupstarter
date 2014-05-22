<?php

Yii::import('application.models._base.BaseTagUser');

class TagUser extends BaseTagUser
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}