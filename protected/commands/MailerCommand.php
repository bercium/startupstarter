
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
      
      $activation_url = '<a href="'.absoluteURL()."/user/registration?id=".$user->key.'">Register here</a>';
      $content = "This is just a friendly reminder to activate your account on Cofinder.
                  </br><br>
                  Cofinder is a web platform through which you can share your ideas with the like minded entrepreneurs, search for people to join your project or join an interesting project yourself.
                  <br /><br />If we got your attention you can ".$activation_url."!";
      
      $message->setBody(array("content"=>$content,"email"=>$user->email), 'text/html');
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
    $hidden = UserStat::model()->findAll("completeness < :comp AND status = :status",array(":comp"=>PROFILE_COMPLETENESS_MIN, ":status"=>1));
    foreach ($hidden as $stat){
      $email = $stat->user->email;
      $message->subject = $stat->user->name." your profile is not visible!";
      
      $content = 'Your profile on Cofinder is not visible due to lack of information you provided. 
                  If you wish to be found we suggest you take a few minutes and fill it up.
                  <br /><br />
                  Just click here and <strong><a href="http://www.cofinder.eu/profile">do it now</a></strong>!';
      
      $message->setBody(array("content"=>$content,"email"=>$email), 'text/html');
      $message->setTo($email);
      Yii::app()->mail->send($message);

      $notify = new Notification();
      $notify->user_id = $stat->user_id;
      $notify->type = 'invisible';
    }
    return 0;
  }
  
}