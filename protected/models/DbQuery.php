<?php

Yii::import('application.models._base.BaseDbQuery');

class DbQuery extends BaseDbQuery
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}