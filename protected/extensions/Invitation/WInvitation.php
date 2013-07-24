<?php

class WInvitation extends CWidget
{
  
    public function init()
    {
      $user = User::model()->findByPk(Yii::app()->user->id);
 // send invitations
      if (!empty($_POST['invite-email']) && $user && $user->invitations > 0){

        // create invitation
        $invitation = new Invite();
        $invitation->email = $_POST['invite-email'];
        $invitation->id_sender = Yii::app()->user->id;
        $invitation->key = md5(microtime().$invitation->email);

        if (!empty($_POST['invite-idea'])){
          $checkUser = UserMatch::model()->findByAttributes(array("user_id"=>$user->id));
          $checkIdea = IdeaMember::model()->findByAttributes(array("idea_id"=>$_POST['invite-idea'], "match_id"=>$checkUser->id));
          if ($checkIdea){
            $invitation->id_idea = $_POST['invite-idea']; // invite to idea
            $invitee = User::model()->findByAttributes(array("email"=>$invitation->email));
            if ($invitee){
              $invitation->id_receiver = $invitee->id;
            }

            
            if ($invitation->save()){
              $user->invitations = $user->invitations-1;
              $user->save();
              
              $idea = IdeaTranslation::model()->findByAttributes(array("idea_id"=>$invitation->id_idea),array('order' => 'FIELD(language_id, 40) DESC'));
              
              // is user in system
              if ($invitee){
                $activation_url = '<a href="'.Yii::app()->createAbsoluteUrl('/profile/acceptInvitation')."?id=".$invitation->id_idea.'">Accept invitation</a>';
                $this->sendMail($invitation->email,
                                "You have been invited to join a project on cofinder", 
                                $user->name." ".$user->surname." invited you to become a member of a project called '".$idea->title."'".
                                                "<br /><br />You can accept his invitation inside your cofinder profile or by clicking ".$activation_url."!");
              }else{
                // invite user to system
                $invitation = new Invite();
                $invitation->email = $_POST['invite-email'];
                $invitation->id_sender = Yii::app()->user->id;
                $invitation->key = md5(microtime().$invitation->email);
                $invitation->save();
                
                $activation_url = '<a href="'.Yii::app()->createAbsoluteUrl('/user/registration')."?id=".$invitation->key.'">Register here</a>';
                $this->sendMail($invitation->email,
                                "You have been invited to join cofinder", 
                                "We've been hard at work on our new service called cofinder.
                                                It is a web platform through which you can share your ideas with the like minded entrepreneurs and search for interesting projects to join. 
                                                <br /><br /> ".$user->name." ".$user->surname." thinks you might be the right person to test our private beta.
                                                <br /><br /> If we got your attention you can ".$activation_url."!");
              }
              setFlash("invitationMessage",Yii::t('msg','Invitation to add new member send.'));
              
            }else setFlash("invitationMessage",Yii::t('msg','Unable to send invitation! Eather user is already invited or the email you provided is incorrect.'),'alert');
          }else setFlash("invitationMessage",Yii::t('msg','Not able to invite this person to this project.'),'alert');
          
        }else if ($invitation->save()){
          $user->invitations = $user->invitations-1;
          $user->save();

          $activation_url = '<a href="'.Yii::app()->createAbsoluteUrl('/user/registration')."?id=".$invitation->key.'">Register here</a>';
          $this->sendMail($invitation->email,
                          "You have been invited to join cofinder", 
                          "We've been hard at work on our new service called cofinder.
                                          It is a web platform through which you can share your ideas with the like minded entrepreneurs and search for interesting projects to join. 
                                          <br /><br /> ".$user->name." ".$user->surname." thinks you might be the right person to test our private beta.
                                          <br /><br /> If we got your attention you can ".$activation_url."!");

          setFlash("invitationMessage",Yii::t('msg','Invitation send.'));
          //Yii::app()->user->setFlash("invitationMessage",Yii::t('msg','Invitation send.'));
        }else setFlash("invitationMessage",Yii::t('msg','This user is already invited.','alert'));
          //Yii::app()->user->setFlash("invitationMessage",Yii::t('msg','This user is already invited.'));

      }
      
      $this->render("invite",array("invitations"=>$user->invitations));
      
    }
 
    public function run()
    {
        // this method is called by CController::endWidget()
    }
    
    
    private function sendMail($email, $subject, $content){
      // send mail
      $message = new YiiMailMessage;
      $message->view = 'system';      
      
      $message->subject = $subject;
      $message->setBody(array("content"=>$content), 'text/html');
      
      $message->addTo($email);
      $message->from = Yii::app()->params['noreplyEmail'];
      Yii::app()->mail->send($message);
    }
    
}?>



    