<?php

Yii::import('application.models._base.BaseNotification');

class Notification extends BaseNotification
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}