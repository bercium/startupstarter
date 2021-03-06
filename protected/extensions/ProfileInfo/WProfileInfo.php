<?php

class WProfileInfo extends CWidget
{
    public $style = '';
  
    public function init()
    {
      $comp = new Completeness();
      
      $perc = $comp->getPercentage();
      //$perc = Yii::app()->user->getState('percentage');
      if ($perc < PROFILE_COMPLETENESS_MIN){
        setFlash('WProfileInfoHint1',array('msg'=>Yii::t('msg','Your profile will not be visible to the public because it is only {n}% completed! %s',array($perc)),
                                           'actions'=>array(array('hint'=>Yii::t('app','profile details'),'action'=>Yii::app()->createUrl('profile/completeness')))), "alert", false);
        $percClass = 'alert';
      }
      else if ($perc < PROFILE_COMPLETENESS_OK) $percClass = '';
      else $percClass = 'success';
      
      if ($this->style == 'sidebar'){
        $user = User::model()->findByPk(Yii::app()->user->id);
        if (!Yii::app()->user->hasFlash('WProfileInfoHint')){
          $hint = $comp->getHint();
          if ($hint !== false) setFlash('WProfileInfoHint',array('msg'=>Yii::t('app','Hint').": ".$hint['hint'].' %s','actions'=>array(array('hint'=>Yii::t("app",'Do it now!'),'action'=>$hint['action']))), "info", ($perc >= PROFILE_COMPLETENESS_OK));
          //$this->calculatePerc();
        }

        $views = ClickUser::model()->count("user_click_id = :userID",array(":userID"=>Yii::app()->user->id));
        
   
        
        $this->render("detail",array("perc"=>$perc,"percClass"=>$percClass,
                                     "memberDate"=>$user->create_at,
                                     "views"=>$views,
                                     "invites"=>$user->invitations));
        
      }else if ($this->style == 'hint'){
        if (!Yii::app()->user->hasFlash('WProfileInfoHint')){
          $hint = $comp->getHint();
          if ($hint !== false) setFlash('WProfileInfoHint',array('msg'=>Yii::t('app','Hint').": ".$hint['hint'].' %s','actions'=>array(array('hint'=>Yii::t("app",'Do it now!'),'action'=>$hint['action']))), "info", ($perc >= PROFILE_COMPLETENESS_OK));
          //$this->calculatePerc();
        }
      }
      else $this->render("simple",array("perc"=>$perc,"percClass"=>$percClass));
    }
 
    public function run()
    {
        // this method is called by CController::endWidget()
    }
    
    /*
    public static function calculatePerc(){
      $perc = 0; //rand(1,100);

      $messages = array();
      if (Yii::app()->user->id){
        $user = User::model()->findByPk(Yii::app()->user->id);
        
        /*
        "surname" => array(
              "group"=>"",
              "name"=>"",
              "hint"=>"",
              "action"=>"",
              "active"=>false,
              "weight"=>0
              )
        ID
        GROUP
        NAME
        HINT
        ACTION
        ACTIVE
        * /

        if ($user->surname != '') $perc+=10;
        else $messages[] = array("hint"=>Yii::t('msg',"We recommend that you fill out your personal information."),
                                  "action"=>Yii::app()->createUrl("profile")."#link_personal");

        if ($user->address != '') $perc+=7;
        else $messages[] = array("hint"=>Yii::t('msg',"We recommend that you fill out your personal information."),
                                  "action"=>Yii::app()->createUrl("profile")."#link_personal");
        
        if ($user->avatar_link != '') $perc+=10;
        else $messages[] = array("hint"=>Yii::t('msg',"Selecting an avatar will make you more recognizable."),
                                  "action"=>Yii::app()->createUrl("profile")."#link_personal");
        
        
        if ($user->newsletter != '') $perc+=6;
        else $messages[] = array("hint"=>Yii::t('msg',"Subscribe to newsletter and get all important updates."),
                                  "action"=>"profile/account");
        

        $userMatch = UserMatch::model()->find('user_id=:userID', array(':userID'=>Yii::app()->user->id));

        $count = UserLink::Model()->count("user_id=:userID", array("userID" => Yii::app()->user->id));
        if ($count > 0) $perc+=3;
        else $messages[] = array("hint"=>Yii::t('msg',"Add some links."),
                                  "action"=>Yii::app()->createUrl("profile")."#link_personal");

        if ($userMatch){
          $perc+=1;
          $idMatch = $userMatch->id;
          if ($userMatch->available != '') $perc+=10;
          else $messages[] = array("hint"=>Yii::t('msg',"Fill out your profile details."),
                                    "action"=>Yii::app()->createUrl("profile")."#link_personal");
          
          if ($userMatch->country != '') $perc+=7;
          else $messages[] = array("hint"=>Yii::t('msg',"Fill out your profile details."),
                                    "action"=>Yii::app()->createUrl("profile")."#link_personal");
          
          if ($userMatch->city != '') $perc+=7;
          else $messages[] = array("hint"=>Yii::t('msg',"Fill out your profile details."),
                                    "action"=>Yii::app()->createUrl("profile")."#link_personal");
         

          $count = UserCollabpref::Model()->count("match_id=:matchID", array("matchID" => $idMatch));
          if ($count > 0) $perc+=10;
          else $messages[] = array("hint"=>Yii::t('msg',"What is your prefered Collaboration."),
                                    "action"=>Yii::app()->createUrl("profile"));
          

          $count = UserSkill::Model()->count("match_id=:matchID", array("matchID" => $idMatch));
          if ($count > 0) $perc+=10;
          else $messages[] = array("hint"=>Yii::t('msg',"Add some skills."),
                                   "action"=>Yii::app()->createUrl("profile")."#link_skill");

          if ($count > 2) $perc+=3;
          if ($count > 4) $perc+=3;
          if ($count < 5) $messages[] = array("hint"=>Yii::t('msg',"Adding more skills will improve your profile visibility."),
                                               "action"=>Yii::app()->createUrl("profile")."#link_skill");


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
            if (!$owner && !$member) $messages[] = array("hint"=>Yii::t('msg',"Create or take part in a project."),
                                                          "action"=>Yii::app()->createUrl("profile/projects"));
            
            // add idea to percentage???
          }else $messages[] = array("hint"=>Yii::t('msg',"Create or take part in a project."),
                                    "action"=>Yii::app()->createUrl("profile/projects"));

        }else $messages[] = array("hint"=>Yii::t('msg',"Fill out your profile details."),
                                  "action"=>Yii::app()->createUrl("profile"));
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
      //if ($msg) return $messages[rand(0,count($messages)-1)];
      $rand = rand(0,count($messages)-1);
      if (count($messages) > 0){
        setFlash('WProfileInfoHint',array('msg'=>$messages[$rand]['hint'].' %s <span class="icon-long-arrow-right"></span>','actions'=>array(array('hint'=>Yii::t("app",'Do it now!'),'action'=>$messages[$rand]['action']))), "info", false);
        //Yii::app()->user->setFlash('WProfileInfoHint',$messages[$rand]);
      }
    }*/
    
}
