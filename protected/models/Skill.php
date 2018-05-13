<?php

Yii::import('application.models._base.BaseSkill');

class Skill extends BaseSkill
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

  public function defaultScope(){
    return array(
       'order'=>'name, count',
    );
  }  
}