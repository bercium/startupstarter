<?php

Yii::import('application.models._base.BaseKeyword');

class Keyword extends BaseKeyword
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}