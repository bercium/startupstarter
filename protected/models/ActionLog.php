<?php

Yii::import('application.models._base.BaseActionLog');

class ActionLog extends BaseActionLog
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}