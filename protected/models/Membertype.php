<?php

Yii::import('application.models._base.BaseMembertype');

class Membertype extends BaseMembertype
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function findAllTranslated(){
		if (Yii::app()->getLanguage() == 'en') return Membertype::model()->findAll();
		else{
			$lang = Language::model()->findByAttributes(array("language_code"=>Yii::app()->getLanguage()));
			$criteria=new CDbCriteria();
			$criteria->condition = " `table` = 'membertype' AND language_id=".$lang->id;
			$trans = Translation::model()->findAll($criteria);
			$result = array();
			// does not use original values if not translated
			foreach ($trans as $row){
				$result[] = array("id"=>$row->row_id,"name"=>$row->translation);
			}
			return $result;
			//return Translation::model()->findAll($criteria);
		}
	}
  
  public function defaultScope(){
    return array(
       'order'=>'name',
    );
  }	
}