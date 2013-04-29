<?php

class WProfileInfo extends CWidget
{
    public $detail = false;
  
    public function init()
    {
      $perc = Yii::app()->user->getState('percentage');
      if ($perc < 40) $percClass = 'alert';
      else if ($perc < 80) $percClass = '';
      else $percClass = 'success';
      
      if ($this->detail){
        $user = User::model()->findByPk(Yii::app()->user->id);
        $message = $this->calculatePerc(true);
        $views = ClickUser::model()->count("user_id = :userID",array(":userID"=>Yii::app()->user->id));
        $this->render("detail",array("perc"=>$perc,"percClass"=>$percClass,
                                     "memberDate"=>$user->create_at,
                                     "hint"=>$message,
                                     "views"=>$views));
      }
      else $this->render("simple",array("perc"=>$perc,"percClass"=>$percClass));
    }
 
    public function run()
    {
        // this method is called by CController::endWidget()
    }
    
    public static function calculatePerc($return = false){
      $perc = 0; //rand(1,100);

      $messages = array();
      if (Yii::app()->user->id){
        $user = User::model()->findByPk(Yii::app()->user->id);

        if ($user->surname != '') $perc+=10;
        else $messages[] = Yii::t('msg',"Try filling up your personal information.");

        if ($user->address != '') $perc+=7;
        else $messages[] = Yii::t('msg',"Try filling up your personal information.");
        
        if ($user->avatar_link != '') $perc+=10;
        else $messages[] = Yii::t('msg',"Selecting an avatar will give you more visibility.");
        
        
        if ($user->newsletter != '') $perc+=6;
        else $messages[] = Yii::t('msg',"Subscribe to newsletter and get all important updates.");
        

        $userMatch = UserMatch::model()->find('user_id=:userID', array(':userID'=>Yii::app()->user->id));

        $count = UserLink::Model()->count("user_id=:userID", array("userID" => Yii::app()->user->id));
        if ($count > 0) $perc+=3;
        else $messages[] = Yii::t('msg',"Add some links.");

        if ($userMatch){
          $perc+=1;
          $idMatch = $userMatch->id;
          if ($userMatch->available != '') $perc+=10;
          else $messages[] = Yii::t('msg',"Fill up your profile details.");
          
          if ($userMatch->country != '') $perc+=7;
          else $messages[] = Yii::t('msg',"Fill up your profile details.");
          
          if ($userMatch->city != '') $perc+=7;
          else $messages[] = Yii::t('msg',"Fill up your profile details.");
         

          $count = UserCollabpref::Model()->count("match_id=:matchID", array("matchID" => $idMatch));
          if ($count > 0) $perc+=10;
          else $messages[] = Yii::t('msg',"What is your prefered colaboration.");
          

          $count = UserSkill::Model()->count("match_id=:matchID", array("matchID" => $idMatch));
          if ($count > 0) $perc+=10;
          if ($count > 2) $perc+=3;
          if ($count > 4) $perc+=3;
          if ($count < 5) $messages[] = Yii::t('msg',"Add some skils.");


          $ideaMember = IdeaMember::Model()->findAll("match_id=:matchID", array("matchID" => $idMatch));
          if ($ideaMember){
            $perc+=1;
            $owner = 0;
            $member = 0;
            foreach ($ideaMember as $im){
              if ($im->type->id == 2) $owner = 1;
              if ($im->type->id == 1) $member = 1;
            }
            $perc += 6*($owner+$member); //max 12
            if (!$owner && !$member) $messages[] = Yii::t('msg',"Create or become a part of a project.");
            
            // add idea to percentage???
          }else $messages[] = Yii::t('msg',"Create or become a part of a project.");

        }else $messages[] = Yii::t('msg',"Fill up your profile details.");
        // User:: surname, address, avatar_link
        // UserMatch:: available, country, city

        // UserLink:: karkoli
        // UserColabpref:: karkoli
        // UserSkill:: karkoli

        // IdeaMember:: member, creator

        // Idea::
        //throw new Exception("set perc", 123, "none");
        Yii::app()->user->setState("percentage",$perc);
      }
      
      // random notification msg
      if ($return) return $messages[rand(0,count($messages)-1)];
    }
    
}
