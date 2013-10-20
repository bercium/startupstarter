<?php

Yii::import('application.models._base.BaseBackendUser');

class BackendUser extends BaseBackendUser
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}