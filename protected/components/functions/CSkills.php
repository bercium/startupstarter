<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CSkills{
  
  public static function skillSuggest($term) {
    if (!$term) return array();
    
    $skills = Skill::model()->findAll("name LIKE :skill",array(':skill'=>'%'.$term.'%')/*,array('order'=>'count DESC')*/);
    if (!$skills) return array();
    $result = array();
    foreach ($skills as $skill){
      $result[] = $skill->name;
    }
    return $result;
  }
  
}