<?php

Yii::import('application.models._base.BaseUserLink');

class UserLink extends BaseUserLink
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}