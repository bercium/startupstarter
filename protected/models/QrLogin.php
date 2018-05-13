<?php

Yii::import('application.models._base.BaseQrLogin');

class QrLogin extends BaseQrLogin
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}