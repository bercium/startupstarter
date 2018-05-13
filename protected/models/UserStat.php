<?php

Yii::import('application.models._base.BaseUserStat');

class UserStat extends BaseUserStat
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}