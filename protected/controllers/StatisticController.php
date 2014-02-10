<?php

class StatisticController extends Controller
{
  public $layout="//layouts/card";
  
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
			/*array('allow', // allow all users to perform actions
        'actions'=>array('index','error','logout','about','terms','notify','notifyFacebook','suggestCountry',
                         'suggestSkill','suggestCity','unbsucribeFromNews','cookies','sitemap','startupEvents',
                         'applyForEvent','vote','clearNotif'),
				'users'=>array('*'),
			),*/
			/*array('allow', // allow authenticated user to perform 'create' and 'update' actions
        'actions'=>array(),
				'users'=>array('@'),
			),*/
			array('allow', // allow admin user to perform actions:
				'actions'=>array('index','userCommunication'),
				'users'=>Yii::app()->getModule('user')->getAdmins(),
			),
			/*array('deny',  // deny all users
				'users'=>array('*'),
			),*/
		);
	}
  
  
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			/*'page'=>array(
				'class'=>'CViewAction',
			),*/
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex($id = 1){
    $this->render('index');
 	}
  
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionUserCommunication(){
    $result = Yii::app()->db->createCommand('SELECT user_from_id, user_to_id,idea_to_id,COUNT(*) As c FROM message GROUP BY user_from_id, user_to_id,idea_to_id')->queryAll();
    
    $allUsers = User::model()->count();
    $activeUsers = User::model()->countByAttributes(array('status'=>1));
    $usersCanSendMsg = UserStat::model()->count("completeness >= :comp",array(':comp'=>PROFILE_COMPLETENESS_MIN));
    
    //$usersCanSendMsg = 1;
    
    $stat = array();
    $allMsg = 0;
    foreach ($result as $row){
      if (isset($stat[$row['user_from_id']."-".$row['user_to_id']."-".$row['idea_to_id']]))
         $stat[$row['user_from_id']."-".$row['user_to_id']."-".$row['idea_to_id']] += $row['c'];
      else if (isset($stat[$row['user_to_id']."-".$row['user_from_id']."-".$row['idea_to_id']]))
         $stat[$row['user_to_id']."-".$row['user_from_id']."-".$row['idea_to_id']] += $row['c'];
      else $stat[$row['user_from_id']."-".$row['user_to_id']."-".$row['idea_to_id']] = $row['c'];
      $allMsg += $row['c'];
    }
    
    $this->render('usr_com',array('pairs'=>count($stat),'all'=>$allMsg,'max'=>max($stat),
                  'activeUsers'=>$activeUsers,'allUsers'=>$allUsers,'usersCanSendMsg'=>$usersCanSendMsg));
 	}  
	
}