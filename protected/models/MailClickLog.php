<?php

Yii::import('application.models._base.BaseMailClickLog');

class MailClickLog extends BaseMailClickLog
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}