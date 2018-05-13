<?php

Yii::import('application.models._base.BaseEvent');

class Event extends BaseEvent
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}