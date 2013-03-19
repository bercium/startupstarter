<?php

Yii::import('application.models._base.BaseUserShare');

class UserShare extends BaseUserShare
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}