<?php

class WProgressBar extends CWidget
{
    public $height = '';
    public $showPerc = false;
  
    public function init()
    {
      $perc = Yii::app()->user->getState('percentage');
      if ($perc < 40) $percClass = 'alert';
      else if ($perc < 80) $percClass = '';
      else $percClass = 'success';
      
      $class = "";
      if ($this->height) $class = 'style="height:'.$this->height.'px;"';
      
      $style = '';
      if ($this->showPerc) $style = 'line-height:'.($this->height - 4).'px;"';
      
                      
      echo'<div class="progress '.$percClass.' round" '.$class.'><span class="meter" style="width:'.$perc.'%; text-align:center; font-size:10px; vertical-align:middle; '.$style.'">'.($this->showPerc?$perc."%":'').'</span></div>';
    }
 
    public function run()
    {
        // this method is called by CController::endWidget()
    }
    
    public static function calculatePerc(){

      $perc = 0; //rand(1,100);
      $user = User::model()->findByPk(Yii::app()->user->id);

      if ($user->surname != '') $perc+=10;
      if ($user->address != '') $perc+=7;
      if ($user->avatar_link != '') $perc+=10;

      $userMatch = UserMatch::model()->find('user_id=:userID', array(':userID'=>Yii::app()->user->id));

      $count = UserLink::Model()->count("user_id=:userID", array("userID" => Yii::app()->user->id));
      if ($count > 0) $perc+=3;

      if ($userMatch){
        $perc+=1;
        $idMatch = $userMatch->id;
        if ($userMatch->available != '') $perc+=11;
        if ($userMatch->country != '') $perc+=7;
        if ($userMatch->city != '') $perc+=7;

        $count = UserCollabpref::Model()->count("match_id=:matchID", array("matchID" => $idMatch));
        if ($count > 0) $perc+=11;

        $count = UserSkill::Model()->count("match_id=:matchID", array("matchID" => $idMatch));
        if ($count > 0) $perc+=14;
        if ($count > 2) $perc+=3;
        if ($count > 4) $perc+=3;

        $ideaMember = IdeaMember::Model()->findAll("match_id=:matchID", array("matchID" => $idMatch));
        if ($ideaMember){
          $perc+=1;
          $owner = 0;
          $member = 0;
          foreach ($ideaMember as $im){
            if ($im->type == 2) $owner = 1;
            if ($im->type == 1) $member = 1;
          }
          $perc += 6*($owner+$member); //max 12
          // add idea to percentage???
        }

      }
      // User:: surname, address, avatar_link
      // UserMatch:: available, country, city

      // UserLink:: karkoli
      // UserColabpref:: karkoli
      // UserSkill:: karkoli

      // IdeaMember:: member, creator

      // Idea::

      Yii::app()->user->setState("percentage",$perc);
    }
}
