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
    echo $this->consoleCommand('mailer','notifyHiddenProfiles');
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
