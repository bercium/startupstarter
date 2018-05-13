<?php

Yii::import('application.models._base.BaseIdea');

class Idea extends BaseIdea
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}