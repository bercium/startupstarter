<?php

Yii::import('application.models._base.BaseAvailable');

class Available extends BaseAvailable
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}