<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Completeness{
  
  private $details = array();
  
  
  /**
   * init all details and return them in array
   */
  public function init($user_id = null){

    if ($user_id == null) $user_id = Yii::app()->user->id;
    
    $this->details = array();
    if ($user_id){
      
      $user = User::model()->findByPk($user_id);

      $this->details[] = array(
            "group"=>Yii::t('app',"Personal information"),
            "name"=>Yii::t('app',"First name"),
            "value"=>$user->name,
            "hint"=>Yii::t('msg',"Try filling up your personal information."),
            "action"=>Yii::app()->createUrl("profile")."#link_personal",
            "active"=>($user->name != ''),
            "weight"=>0, // weight 0 won't affect your percentage score
            );
      
      $this->details[] = array(
            "group"=>Yii::t('app',"Personal information"),
            "name"=>Yii::t('app',"Last name"),
            "value"=>$user->surname,
            "hint"=>Yii::t('msg',"Try filling up your personal information."),
            "action"=>Yii::app()->createUrl("profile")."#link_personal",
            "active"=>($user->surname != ''),
            "weight"=>10,
            );
      
      
      $this->details[] = array(
            "group"=>Yii::t('app',"Personal information"),
            "name"=>Yii::t('app',"Address"),
            "value"=>$user->address,
            "hint"=>Yii::t('msg',"Try filling up your personal information."),
            "action"=>Yii::app()->createUrl("profile")."#link_personal",
            "active"=>($user->address != ''),
            "weight"=>0,
            );      

      $this->details[] = array(
            "group"=>Yii::t('app',"Personal information"),
            "name"=>Yii::t('app',"Profile picture"),
            "value"=>"",
            "hint"=>Yii::t('msg',"Selecting an avatar will make you more recognizable."),
            "action"=>Yii::app()->createUrl("profile")."#link_personal",
            "active"=>($user->avatar_link != ''),
            "weight"=>15,
            );

      $this->details[] = array(
            "group"=>Yii::t('app',"Personal information"),
            "name"=>Yii::t('app',"Bio"),
            "value"=>"",
            "hint"=>Yii::t('msg',"Tell others something interesting about yourself."),
            "action"=>Yii::app()->createUrl("profile")."#link_personal",
            "active"=>($user->bio != ''),
            "weight"=>0,
            );        

      //******************************************************************
      // Profile
      //******************************************************************


      $userMatch = UserMatch::model()->find('user_id=:userID', array(':userID'=>$user_id));

      $count = UserLink::Model()->count("user_id=:userID", array("userID" => $user_id));

      $this->details[] = array(
            "group"=>Yii::t('app',"Profile details"),
            "name"=>Yii::t('app',"Links"),
            "value"=>Yii::t('app',"{n} link|{n} links",array($count)),
            "hint"=>Yii::t('msg',"Add some links."),
            "action"=>Yii::app()->createUrl("profile")."#link_personal",
            "active"=>($count > 0),
            "weight"=>5,
            );      
      
      $this->details[] = array(
            "group"=>Yii::t('app',"Personal information"),
            "name"=>Yii::t('app',"Country"),
            "value"=>$userMatch->country,
            "hint"=>Yii::t('msg',"Try filling up your personal information."),
            "action"=>Yii::app()->createUrl("profile")."#link_personal",
            "active"=>($userMatch->country != ''),
            "weight"=>7,
            );
      
      $this->details[] = array(
            "group"=>Yii::t('app',"Personal information"),
            "name"=>Yii::t('app',"City"),
            "value"=>$userMatch->city,
            "hint"=>Yii::t('msg',"Try filling up your personal information."),
            "action"=>Yii::app()->createUrl("profile")."#link_personal",
            "active"=>($userMatch->city != ''),
            "weight"=>7,
            );


      $this->details[] = array(
            "group"=>Yii::t('app',"Profile details"),
            "name"=>Yii::t('app',"Availability"),
            "value"=>$userMatch->available,
            "hint"=>Yii::t('msg',"Fill up your profile details."),
            "action"=>Yii::app()->createUrl("profile"),
            "active"=>($userMatch->available != 0),
            "weight"=>10,
            );        

      $count = UserCollabpref::Model()->count("match_id=:matchID", array("matchID" => $userMatch->id));
      $this->details[] = array(
            "group"=>Yii::t('app',"Profile details"),
            "name"=>Yii::t('app',"Collaboration"),
            "value"=>"",
            "hint"=>Yii::t('msg',"What is your prefered Collaboration."),
            "action"=>Yii::app()->createUrl("profile"),
            "active"=>($count > 0),
            "weight"=>5,
            );

      $count = UserSkill::Model()->count("match_id=:matchID", array("matchID" => $userMatch->id));
      $this->details[] = array(
            "group"=>Yii::t('app',"Profile details"),
            "name"=>Yii::t('app',"Skills"),
            "value"=>"", //Yii::t('app',"{n} skills|{n} skills",array($count)),
            "hint"=>Yii::t('msg',"Adding more skills will improve your profile visibility. Add at least 5."),
            "action"=>Yii::app()->createUrl("profile")."#link_skill",
            "active"=>($count > 5),
            "weight"=>20,
            );

      $ideaMember = IdeaMember::Model()->findAll("match_id=:matchID", array("matchID" => $userMatch->id));
      $owner = 0;
      $member = 0;
      if ($ideaMember){
        foreach ($ideaMember as $im){
          if ($im->type->id == 2) $owner = 1;
          if ($im->type->id == 1) $member = 1;
        }
        if (!$owner && !$member){
          $hasProject = true;
        }
        // add idea to percentage???
      }

      $this->details[] = array(
            "group"=>Yii::t('app',"Projects"),
            "name"=>Yii::t('app',"Owner of a project"),
            "value"=>"", //Yii::t('app',"{n} skills|{n} skills",array($count)),
            "hint"=>Yii::t('msg',"Create or take part in a project."),
            "action"=>Yii::app()->createUrl("profile/projects"),
            "active"=>($member > 0),
            "weight"=>5,
            );        
      $this->details[] = array(
            "group"=>Yii::t('app',"Projects"),
            "name"=>Yii::t('app',"Member of a project"),
            "value"=>"", //Yii::t('app',"{n} skills|{n} skills",array($count)),
            "hint"=>Yii::t('msg',"Create or take part in a project."),
            "action"=>Yii::app()->createUrl("profile/projects"),
            "active"=>($owner > 0),
            "weight"=>5,
            );

      //*********************************************************************
      // SETTINGS
      //*********************************************************************
      
      $this->details[] = array(
            "group"=>Yii::t('app',"Settings"),
            "name"=>Yii::t('app',"Page language"),
            "value"=>"", //Yii::t('app',"{n} skills|{n} skills",array($count)),
            "hint"=>Yii::t('msg',"Set your prefered language."),
            "action"=>Yii::app()->createUrl("profile/account"),
            "active"=>($user->language_id),
            "weight"=>0,
            );      
      $this->details[] = array(
            "group"=>Yii::t('app',"Settings"),
            "name"=>Yii::t('app',"Newsletter"),
            "value"=>"", //Yii::t('app',"{n} skills|{n} skills",array($count)),
            "hint"=>Yii::t('msg',"We can keep you updated"),
            "action"=>Yii::app()->createUrl("profile/account"),
            "active"=>$user->newsletter,
            "weight"=>5,
            );      
      $this->details[] = array(
            "group"=>Yii::t('app',"Settings"),
            "name"=>Yii::t('app',"Public name"),
            "value"=>"", //Yii::t('app',"{n} skills|{n} skills",array($count)),
            "hint"=>Yii::t('msg',"You will be more easyly accesed"),
            "action"=>Yii::app()->createUrl("profile/account"),
            "active"=>($user->vanityURL != ''),
            "weight"=>0,
            );      
      
      return $this->details;
    }
  }
  
  /**
   * get only percentage
   */
  public function getPercentage($user_id = null){
    if ($user_id == null) $user_id = Yii::app()->user->id;
    $stat = UserStat::model()->findByAttributes(array("user_id"=>$user_id));
    
    if ($stat->completeness) return $stat->completeness;
    else return 4;
  }
  
  
  /**
   * save percentage of user to DB
   */
  public function setPercentage($user_id = null){
    if ($user_id == null) $user_id = Yii::app()->user->id;
    if ($this->details == array()) $this->init($user_id);
    
    $maxVal = 0;
    $realVal = 0;
    foreach ($this->details as $detail){
      $maxVal += $detail["weight"];
      
      if ($detail["active"]) $realVal += $detail["weight"];
    }
    
    $perc = round($realVal/$maxVal*100);
    $stat = UserStat::model()->findByAttributes(array("user_id"=>$user_id));
    if ($stat == null){
      $stat = new UserStat();
      $stat->user_id = $user_id;
    }
    $stat->completeness = $perc;
    $stat->save();

    return $perc;
  }
  
  /**
   * get random hint out of all uncompleted
   */
  public function getHint(){
    if ($this->details == array()) $this->init();
    
    $msgs = array();
    foreach ($this->details as $detail){
      if (!$detail["active"] && $detail["weight"] > 0) $msgs[] = $detail;
    }
    
    if (count($msgs) == 0) return false;
    
    $rand = rand(0,count($msgs)-1);
    return $msgs[$rand];
  }
  
}