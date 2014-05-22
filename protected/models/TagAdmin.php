<?php

Yii::import('application.models._base.BaseTagAdmin');

class TagAdmin extends BaseTagAdmin
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}