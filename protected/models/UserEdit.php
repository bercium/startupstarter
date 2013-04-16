<?php

Yii::import('application.models._base.BaseUserEdit');

class UserEdit extends BaseUserEdit
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
  
    public function afterSave() {
      if (get_class(Yii::app())=='CWebApplication') {
        Yii::app()->user->updateSession();
      }
      return parent::afterSave();
    }
}