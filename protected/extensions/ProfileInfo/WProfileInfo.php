<?php

class WProfileInfo extends CWidget
{
    public $style = '';
  
    public function init()
    {
      $perc = Yii::app()->user->getState('percentage');
      if ($perc < 40) $percClass = 'alert';
      else if ($perc < 80) $percClass = '';
      else $percClass = 'success';
      
      if ($this->style == 'sidebar'){
        $user = User::model()->findByPk(Yii::app()->user->id);
        if (!Yii::app()->user->hasFlash('WProfileInfoHint')) $this->calculatePerc();

        $views = ClickUser::model()->count("user_id = :userID",array(":userID"=>Yii::app()->user->id));
        
        // send invitations
        if (!empty($_POST['invite-email']) && $user){
          
          // create invitation
          $invitation = new Invite();
          $invitation->email = $_POST['invite-email'];
          $invitation->id_sender = Yii::app()->user->id;
          $invitation->key = md5(microtime().$invitation->email);
          
          if (!empty($_POST['invite-idea'])){
            $invitation->id_idea = $_POST['invite-idea']; // invite to idea
            $invitee = User::model()->findByAttributres(array("email"=>$invitation->email));
            if ($invitee) $invitation->id_receiver = $invitee->id;
          }
          
          if ($invitation->save()){
            $user->invitations = $user->invitations-1;
            $user->save();
            
            
            // send mail
            $message = new YiiMailMessage;
            $message->view = 'system';
            
            if ($invitation->id_receiver){
              $activation_url = '<a href="'.Yii::app()->createAbsoluteUrl('/user/registration')."?id=".$invitation->key.'">'.Yii::t('app',"Register here")."</a>";
              
              $message->setBody(array("content"=>"We've been hard at work on our new service called cofinder.
                                              It is a web platform through which you can share your ideas with the like minded entrepreneurs and search for interesting projects to join. 
                                              <br /><br /> ".$user->name." ".$user->surname." thinks you might be the right person to test our private beta.
                                              <br /><br /> If we got your attention you can ".$activation_url."!"
                                      ), 'text/html');
              $message->subject = Yii::t('msg',"You have been invited to join cofinder");
            }else{
              $idea = IdeaTranslation::model()->findByAttributes(array("idea_id"=>$invitation->id_idea));
              
              $activation_url = '<a href="'.Yii::app()->createAbsoluteUrl('/user/acceptinvitation')."?id=".$invitation->key.'">'.Yii::t('app',"Accept invitation")."</a>";
            
              $projectName = '';
              
              $message->setBody(array("content"=>$user->name." ".$user->surname." invited you to become a member of a project called '".$projectName."'".
                                              "<br /><br />You can accept his invitation inside your cofinder profile or by clicking ".$activation_url."!"
                                      ), 'text/html');
              $message->subject = Yii::t('msg',"You have been invited to join a project on cofinder");
            }
            
            $message->addTo($invitation->email);
            $message->from = Yii::app()->params['noreplyEmail'];
            Yii::app()->mail->send($message);
            
            Yii::app()->user->setFlash("invitationMessage",Yii::t('msg','Invitation send.'));
          }else Yii::app()->user->setFlash("invitationMessage",Yii::t('msg','This user is already invited.'));
          
        }
        
        $this->render("detail",array("perc"=>$perc,"percClass"=>$percClass,
                                     "memberDate"=>$user->create_at,
                                     "views"=>$views,
                                     "invites"=>$user->invitations));
        
      }else if ($this->style == 'hint'){
        if (!Yii::app()->user->hasFlash('WProfileInfoHint')) $this->calculatePerc();
        $this->render("hint",array());
      }
      else $this->render("simple",array("perc"=>$perc,"percClass"=>$percClass));
    }
 
    public function run()
    {
        // this method is called by CController::endWidget()
    }
    
    public static function calculatePerc(){
      $perc = 0; //rand(1,100);

      $messages = array();
      if (Yii::app()->user->id){
        $user = User::model()->findByPk(Yii::app()->user->id);

        if ($user->surname != '') $perc+=10;
        else $messages[] = array("hint"=>Yii::t('msg',"Try filling up your personal information."),
                                  "action"=>Yii::app()->createUrl("profile")."#link_personal");

        if ($user->address != '') $perc+=7;
        else $messages[] = array("hint"=>Yii::t('msg',"Try filling up your personal information."),
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
          else $messages[] = array("hint"=>Yii::t('msg',"Fill up your profile details."),
                                    "action"=>Yii::app()->createUrl("profile")."#link_personal");
          
          if ($userMatch->country != '') $perc+=7;
          else $messages[] = array("hint"=>Yii::t('msg',"Fill up your profile details."),
                                    "action"=>Yii::app()->createUrl("profile")."#link_personal");
          
          if ($userMatch->city != '') $perc+=7;
          else $messages[] = array("hint"=>Yii::t('msg',"Fill up your profile details."),
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

        }else $messages[] = array("hint"=>Yii::t('msg',"Fill up your profile details."),
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
      Yii::app()->user->setFlash('WProfileInfoHint',$messages[$rand]['hint']."|".$messages[$rand]['action']);
    }
    
}
