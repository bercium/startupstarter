
<?php

class MailerCommand extends CConsoleCommand{

	public function actionTest(){
    echo "Test succeded on ".date("d M Y H:i:s");
    return 0;
	}  
  
  /**
   * generates weekly reports for users that want them
   */
	public function actionWeekly(){
    return 0;
    
    $message = new YiiMailMessage;
    //$message->view = 'newsletter';
    $message->setBody('En testni mail', 'text/html');
    $message->subject = "subject";

    // get all users
    $criteria = new CDbCriteria();
    $criteria->condition = 'newsletter=1'; // new
    $users = User::model()->findAll($criteria);
    foreach ($users as $user){
      $message->addBcc($user->email);
    }

    $message->from = Yii::app()->params['adminEmail'];
    Yii::app()->mail->send($message);
    
    //return 0; // all OK // not needed
	}
  
  /**
   * generates monthly reports for users that want them
   */
	public function actionMonthly(){
    return 0;
    
    $message = new YiiMailMessage;
    //$message->view = 'newsletter';
    $message->setBody('En testni mail', 'text/html');
    $message->subject = "subject";

    // get all users
    $criteria = new CDbCriteria();
    $criteria->condition = 'newsletter=1'; // new
    $users = User::model()->findAll($criteria);
    foreach ($users as $user){
      $message->addBcc($user->email);
    }

    $message->from = Yii::app()->params['adminEmail'];
    Yii::app()->mail->send($message);
	}
  
  
  // do this every first wednesday of month
  public function actionNotifyToJoin(){
    $message = new YiiMailMessage;
    $message->view = 'system';
    $message->subject = "Cofinder invitation reminder";
    $message->from = Yii::app()->params['noreplyEmail'];
    
    // send newsletter to all in waiting list
    $invites = Invite::model()->findAll("NOT ISNULL(`key`)");
    foreach ($invites as $user){
      
      $create_at = strtotime($stat->time_invited);
      if ($create_at < strtotime('-8 week') || $create_at >= strtotime('-1 day')) continue;     
      if (!
          (($create_at >= strtotime('-1 week')) || 
          (($create_at >= strtotime('-4 week')) && ($create_at < strtotime('-3 week'))) || 
          (($create_at >= strtotime('-8 week')) && ($create_at < strtotime('-7 week'))) )
         ) continue;      
      
      //set mail tracking
      $mailTracking = mailTrackingCode($user->id);
      $ml = new MailLog();
      $ml->tracking_code = mailTrackingCodeDecode($mailTracking);
      $ml->type = 'invitation-reminder';
      $ml->user_to_id = $user->id;
      $ml->save();
    
      //$activation_url = '<a href="'.absoluteURL()."/user/registration?id=".$user->key.'">Register here</a>';
      $activation_url = mailButton("Register here", absoluteURL()."/user/registration?id=".$user->key,'success',$mailTracking,'register-button');
      $content = "This is just a friendly reminder to activate your account on Cofinder.
                  </br><br>
                  Cofinder is a web platform through which you can share your ideas with the like minded entrepreneurs, search for people to join your project or join an interesting project yourself.
                  <br /><br />If we got your attention you can ".$activation_url."!";
      
      $message->setBody(array("content"=>$content,"email"=>$user->email,"tc"=>$mailTracking), 'text/html');
      $message->setTo($user->email);
      Yii::app()->mail->send($message);
    }
    return 0;
  }
  
  
  // do this every first of month
  public function actionNotifyHiddenProfiles(){
    $message = new YiiMailMessage;
    $message->view = 'system';
    $message->from = Yii::app()->params['noreplyEmail'];
    
    // send newsletter to all in waiting list
    $hidden = UserStat::model()->findAll("completeness < :comp",array(":comp"=>PROFILE_COMPLETENESS_MIN));
    foreach ($hidden as $stat){
      //set mail tracking
      if ($stat->user->status == 0) continue; // skip non active users
      if ($stat->user->lastvisit_at < strtotime('-2 month')) continue; // skip users who haven't been on our platform for more than 2 moths
      
      $mailTracking = mailTrackingCode($stat->user->id);
      $ml = new MailLog();
      $ml->tracking_code = mailTrackingCodeDecode($mailTracking);
      $ml->type = 'invitation-reminder';
      $ml->user_to_id = $stat->user->id;
      $ml->save();
      
      $email = $stat->user->email;
      $message->subject = $stat->user->name." your profile is not visible!";
      
      $content = 'Your profile on Cofinder is not visible due to lack of information you provided. 
                  If you wish to be found we suggest you take a few minutes and '.
              mailButton("fill it up", 'http://www.cofinder.eu/profile','success',$mailTracking,'fill-up-button');
      
      $message->setBody(array("content"=>$content,"email"=>$email,"tc"=>$mailTracking), 'text/html');
      $message->setTo($email);
      Yii::app()->mail->send($message);

      Notifications::setNotification($stat->user_id,Notifications::NOTIFY_INVISIBLE);
    }
    return 0;
  }
  
  // do this every first of month
  public function actionNotifyUnExeptedProfiles(){
    $message = new YiiMailMessage;
    $message->view = 'system';
    $message->from = Yii::app()->params['noreplyEmail'];
    
    // send newsletter to all in waiting list
    $hidden = UserStat::model()->findAll("completeness < :comp",array(":comp"=>PROFILE_COMPLETENESS_MIN));

    foreach ($hidden as $stat){
      //set mail tracking
      if ($stat->user->status != 0) continue; // skip active users
      if ($stat->user->lastvisit_at != '0000-00-00 00:00:00') continue; // skip users who have allready canceled their account
      
      //echo $stat->user->name." - ".$stat->user->email.": ".$stat->user->create_at." (".date('c',strtotime('-4 week'))."     ".date('c',strtotime('-3 week')).")<br />\n";
      $create_at = strtotime($stat->user->create_at);
      if ($create_at < strtotime('-8 week') || $create_at >= strtotime('-1 day')) continue;      
      if (!
          (($create_at >= strtotime('-1 week')) || 
          (($create_at >= strtotime('-4 week')) && ($create_at < strtotime('-3 week'))) || 
          (($create_at >= strtotime('-8 week')) && ($create_at < strtotime('-7 week'))) )
         ) continue;
      

      //echo "SEND: ".$stat->user->name." - ".$stat->user->email.": ".$stat->user->create_at." (".$stat->completeness.")<br />\n";
      //echo 'http://www.cofinder.eu/profile/registrationFlow?key='.substr($stat->user->activkey,0, 10).'&email='.$stat->user->email;

      //continue;
      //set mail tracking
      $mailTracking = mailTrackingCode($stat->user->id);
      $ml = new MailLog();
      $ml->tracking_code = mailTrackingCodeDecode($mailTracking);
      $ml->type = 'registration-flow-reminder';
      $ml->user_to_id = $stat->user->id;
      $ml->save();

      $email = $stat->user->email;
      $message->subject = $stat->user->name." your profile is moments away from approval";

      $content = "We couldn't approve your profile  just yet since you haven't provided enough information."
              . "Fill your profile and we will revisit your application.".
              mailButton("Do it now", 'http://www.cofinder.eu/profile/registrationFlow?key='.substr($stat->user->activkey,0, 10).'&email='.$stat->user->email,'success',$mailTracking,'fill-up-button');

      $message->setBody(array("content"=>$content,"email"=>$email,"tc"=>$mailTracking), 'text/html');
      $message->setTo($email);
      //Yii::app()->mail->send($message);

      Notifications::setNotification($stat->user_id,Notifications::NOTIFY_INVISIBLE);

    }
    return 0;
  }  
  
}