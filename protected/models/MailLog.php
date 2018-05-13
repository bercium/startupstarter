<?php

Yii::import('application.models._base.BaseMailLog');

class MailLog extends BaseMailLog
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}