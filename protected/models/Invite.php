<?php

Yii::import('application.models._base.BaseInvite');

class Invite extends BaseInvite
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}