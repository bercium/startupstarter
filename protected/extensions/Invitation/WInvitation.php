<?php

class WInvitation extends CWidget
{
  
    public function init()
    {
      $user = User::model()->findByPk(Yii::app()->user->id);
 // send invitations
      if (!empty($_POST['invite-email']) && $user){

        // create invitation
        $invitation = new Invite();
        $invitation->email = $_POST['invite-email'];
        $invitation->id_sender = Yii::app()->user->id;
        $invitation->key = md5(microtime().$invitation->email);

        $checkIdea = true;
        if (!empty($_POST['invite-idea'])){
          $checkUser = UserMatch::model()->findByAttributes(array("user_id"=>$user->id));
          $checkIdea = IdeaMember::model()->findByAttributes(array("idea_id"=>$_POST['invite-idea'], "match_id"=>$checkUser->match_id));
          if ($checkIdea){
            $invitation->id_idea = $_POST['invite-idea']; // invite to idea
            $invitee = User::model()->findByAttributres(array("email"=>$invitation->email));
            if ($invitee) $invitation->id_receiver = $invitee->id;
          }
        }

        if ($checkIdea && $invitation->save()){
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
            $idea = IdeaTranslation::model()->findAllByAttributes(array("idea_id"=>$invitation->id_idea),null,array('order' => 'FIELD(language_id, 40) DESC'));
            $projectName = '';
            foreach($idea as $row){
              $projectName = $row->title;
              break;
            }
            $activation_url = '<a href="'.Yii::app()->createAbsoluteUrl('/profile/acceptinvitation')."?id=".$invitation->key.'">'.Yii::t('app',"Accept invitation")."</a>";
            $message->setBody(array("content"=>$user->name." ".$user->surname." invited you to become a member of a project called '".$projectName."'".
                                            "<br /><br />You can accept his invitation inside your cofinder profile or by clicking ".$activation_url."!"
                                    ), 'text/html');
            $message->subject = Yii::t('msg',"You have been invited to join a project on cofinder");
          }

          $message->addTo($invitation->email);
          $message->from = Yii::app()->params['noreplyEmail'];
          Yii::app()->mail->send($message);

          setFlash("invitationMessage",Yii::t('msg','Invitation send.'));
          //Yii::app()->user->setFlash("invitationMessage",Yii::t('msg','Invitation send.'));
        }else setFlash("invitationMessage",Yii::t('msg','This user is already invited.'));
          //Yii::app()->user->setFlash("invitationMessage",Yii::t('msg','This user is already invited.'));

      }      
      
      $this->render("invite",array("invitations"=>$user->invitations));
      
    }
 
    public function run()
    {
        // this method is called by CController::endWidget()
    }
    
}?>



    