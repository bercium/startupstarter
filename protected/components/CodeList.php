<?php

        
class CodeList {
  
  public static function clTimePerWeekArray(){
    return array(40=>Yii::t("app","Fulltime"),
                 20=>Yii::t("app","Parttime"),
                 8=>Yii::t("app","Weekends only"),
                );
  }
  
  public static function clTimePerWeekList(){
    $result =  array();
    $array = CodeList::clTimePerWeekArray();
    foreach ($array as $key => $val){
      $result[] = array("value"=>$key,"name"=>$val);
    }
      
    return $result;
  }
  
  public static function clTimePerWeek($value){
    $array = CodeList::clTimePerWeekArray();
    if (isset($array[$value])) return $array[$value];
    else return null;
  }
  
  
  
  public static function clColaborationArray(){
    return array(1=>Yii::t("app","Monetary"),
                 2=>Yii::t("app","Cofounder"),
                 3=>Yii::t("app","Help only"),
                 4=>Yii::t("app","ghjghjb"),
                );
  }
  
  public static function clColaborationList(){
    $result =  array();
    $array = CodeList::clColaborationArray();
    foreach ($array as $key => $val){
      $result[] = array("value"=>$key,"name"=>$val);
    }
      
    return $result;
  }
  
  public static function clColaboration($value){
    $array = CodeList::clColaborationArray();
    if (isset($array[$value])) return $array[$value];
    else return null;
  }  
}