<?php

Yii::import('application.models._base.BaseUserTag');

class UserTag extends BaseUserTag
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}