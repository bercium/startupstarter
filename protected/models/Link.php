<?php

Yii::import('application.models._base.BaseLink');

class Link extends BaseLink
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}