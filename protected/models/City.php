<?php

Yii::import('application.models._base.BaseCity');

class City extends BaseCity
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
  
  public function defaultScope(){
    return array(
       'order'=>'name',
    );
  }  
}