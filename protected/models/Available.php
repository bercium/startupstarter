<?php

Yii::import('application.models._base.BaseAvailable');

class Available extends BaseAvailable
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function findAllTranslated($uninterested = true){
		if (Yii::app()->getLanguage() == 'en'){
      if ($uninterested) return Available::model()->findAll();
      else return $this->findAllActive();
    }
		else{
			$lang = Language::model()->findByAttributes(array("language_code"=>Yii::app()->getLanguage()));
			$criteria=new CDbCriteria();
			$criteria->condition = " `table` = 'available' AND language_id=".$lang->id;
			$trans = Translation::model()->findAll($criteria);
			$result = array();
			// does not use original values if not translated
			foreach ($trans as $row){
        if ($uninterested && ($row->row_id > 1 || $uninterested)) $result[] = array("id"=>$row->row_id,"name"=>$row->translation);
			}
			return $result;
			//return Translation::model()->findAll($criteria);
		}
	}
  
  public function findAllActive(){
    return Available::model()->findAll("id > :time",array(":time"=>1)); // return just active
	}
  
  public function defaultScope(){
    return array(
       'order'=>'id',
    );
  }  
}