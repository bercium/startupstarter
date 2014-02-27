<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CSkills{
  
  /**
   * suggest skils
   * @param string $term - partial term to search for inside DB
   * @return array - array of results
   */
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
  
  /**
   * save skills, removes unused and adds new ones if needed
   * @param string $skils - coma ',' separated string of skill tags
   * @param string $user_id - id of user to add/remove skills from
   * 
   */
  public static function saveSkills($skills, $user_id) {
    $userMatch = UserMatch::model()->findByAttributes(array('user_id'=>$user_id));
    $match_id = $userMatch->id;
    
    $prevSkills = UserSkill::model()->findAllByAttributes(array('match_id'=>$match_id));
    $newSkills = explode(",", $skills);

    foreach ($prevSkills as $skill){
      $found = array_search($skill->skill->name, $newSkills);
      if ($found !== false) unset($newSkills[$found]);
      else{
        // remove skill and decrease count
        UserSkill::model()->deleteByPk($skill->id);
        $se = Skill::model()->findByPk($skill->skill_id);
        if ($se /*&& $se->count > 0*/){
          //$se->count = $se->count - 1;
          //$se->save();
        }
      }
    }
    
    // save skills
    foreach ($newSkills as $newSkill){
      $se = Skill::model()->findByAttributes(array('name'=>$newSkill));
      if ($se){
        //$se->count = $se->count + 1;
        //$se->save();
      }else{
        $se = new Skill();
        $se->name = $newSkill;
        //$se->count = 1;
        $se->save();
      }
      
      $uss = new UserSkill();
      $uss->match_id = $match_id;
      $uss->skill_id = $se->id;
      $uss->save();
    }
    
    
  }
  
}