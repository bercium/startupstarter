<?php

class CronController extends Controller
{
  
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow all users to perform actions
        'actions'=>array(),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
        'actions'=>array(),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform actions:
				'actions'=>array(),
				'users'=>Yii::app()->getModule('user')->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
  
  
  /**
   * 
   */
  function consoleCommand($controller, $action){
    $commandPath = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'commands';
    $runner = new CConsoleCommandRunner();
    $runner->addCommands($commandPath);
    $commandPath = Yii::getFrameworkPath() . DIRECTORY_SEPARATOR . 'cli' . DIRECTORY_SEPARATOR . 'commands';
    $runner->addCommands($commandPath);
    
    $args = array('yiic', $controller, $action); // 'migrate', '--interactive=0'
    //$args = array_merge(array("yiic"), $args);
    ob_start();
    $runner->run($args);
    return htmlentities(ob_get_clean(), null, Yii::app()->charset);    
  }
  
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionTest()
	{
    echo absoluteURL()."\n<br />";
    echo $this->consoleCommand('mailer','test');
  }
	
  
  /**
   * all hidden profiles will be notified every second week
   */
  public function actionNotifyOnWednesday(){
    if (date("W") % 2 == 0){
      echo $this->consoleCommand('mailer','notifyHiddenProfiles');
      echo $this->consoleCommand('mailer','notifyToJoin');
    }
    echo $this->consoleCommand('mailer','notifyUnExeptedProfiles');
  }
  
  /**
   * notify on mondaydailyProjectsPost
   */  
  public function actionNotifyOnMonday(){
    echo $this->consoleCommand('mailer','notifyUnreadMsg');
  }
  
  /**
   * notify once a month
   */
  public function actionNotifyOnceAMonth(){
    echo $this->consoleCommand('mailer','noActivity');
  }
  
  /**
   * test 
   */
  public function actionNotifyTest(){
      $message = new YiiMailMessage;
    $message->view = 'system';
    $message->from = Yii::app()->params['noreplyEmail'];
    
    // send newsletter to all in waiting list
    $hidden = UserStat::model()->findAll("completeness < :comp",array(":comp"=>PROFILE_COMPLETENESS_MIN));

    foreach ($hidden as $stat){
      //set mail tracking
      if ($stat->user->status != 0) continue; // skip active users
      if ($stat->user->newsletter == 0) continue; // skip those who unsubscribed
      if ($stat->user->lastvisit_at != '0000-00-00 00:00:00') continue; // skip users who have already canceled their account
      
      //echo $stat->user->name." - ".$stat->user->email.": ".$stat->user->create_at." (".date('c',strtotime('-4 week'))."     ".date('c',strtotime('-3 week')).")<br />\n";
      $create_at = strtotime($stat->user->create_at);
      /*if ($create_at < strtotime('-8 week') || $create_at >= strtotime('-1 day')) continue;      
      if (!
          (($create_at >= strtotime('-1 week')) || 
          (($create_at >= strtotime('-4 week')) && ($create_at < strtotime('-3 week'))) || 
          (($create_at >= strtotime('-8 week')) && ($create_at < strtotime('-7 week'))) )
         ) continue;*/
      
      //echo $stat->user->email." - ".$stat->user->name." your Cofinder profile is moments away from approval!";

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
      $message->subject = $stat->user->name." your Cofinder account is almost approved"; // 11.6. title change

      $content = "We couldn't approve your profile just yet since you haven't provided enough information."
              . "Please fill your profile and we will revisit your application.".
              mailButton("Do it now", absoluteURL().'/profile/registrationFlow?key='.substr($stat->user->activkey,0, 10).'&email='.$stat->user->email,'success',$mailTracking,'fill-up-button');

      $message->setBody(array("content"=>$content,"email"=>$email,"tc"=>$mailTracking), 'text/html');
      $message->setTo($email);
      Yii::app()->mail->send($message);
      
      echo $stat->user->email."<br />";
      Notifications::setNotification($stat->user_id,Notifications::NOTIFY_INVISIBLE);
    }
    //echo $this->consoleCommand('mailer','notifyUnExeptedProfiles');
  }


  /**
   * 
   */
	public function actionDbBackup(){
    echo $this->consoleCommand('dbbackup','removeOld');
    echo $this->consoleCommand('dbbackup','backup');
  }
  
  /**
   * Add more invites every
   */
  public function actionAddInvites(){
    echo $this->consoleCommand('general','autoAddInvites');
  }
  
  /**
   * load all calendar events
   */
  public function actionLoadCalendars(){
    echo $this->consoleCommand('general','loadCalendars');
  }

  /**
   * post projects on FB
   */
  public function actionDailyProjectsPost(){
    echo $this->consoleCommand('general','dailyProjectsPost');
  }
  
}
