<?php

Yii::import('application.models._base.BaseTagEvent');

class TagEvent extends BaseTagEvent
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}