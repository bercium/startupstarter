<?php

class MessageController extends Controller
{

	public $layout="//layouts/none";

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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
        'actions'=>array('contact','index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow admins only
				'users'=>Yii::app()->getModule('user')->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
  
  
  public function actionContact() {
    
		if(isset($_POST['message']) && ($_POST['message']  > '')){
      
      //Message::model()->findByAttributes();
      //SELECT (COUNT(DISTINCT `user_to_id`)+COUNT(DISTINCT `idea_to_id`)) AS c FROM `message` WHERE 1
      
      // store in DB
      $db_message = new Message;
      $db_message->user_from_id = Yii::app()->user->id;
      
      $db_message->message = $_POST['message'];
      if (!empty($_POST['user'])){
        $db_message->user_to_id = $_POST['user'];
        $replyParams = array('id'=>Yii::app()->user->id,'group'=>'user');
        
        Notifications::setNotification($_POST['user'],Notifications::NOTIFY_MESSAGE);
      }
      if (!empty($_POST['project'])){
        $db_message->idea_to_id = $_POST['project'];
        $replyParams = array('id'=>$_POST['project'],'group'=>'project');
      }
      $db_message->save();

      // message wrapper style

      $wrapperStart = '<br /><br />
                  <div style="border-left: 1px solid #ddd; margin-left: 15px; padding-left: 10px; padding-top:5px;">';
      $wrapperEnd = '</div><br />';
      
      // create MAIL
      $sender = User::model()->findByPk(Yii::app()->user->id);
      
      
      $message = new YiiMailMessage;
      $message_self = new YiiMailMessage;
      
      $message->view = 'system';
            // send to sender
      $message->subject = "New message from ".$sender->name." ".$sender->surname;
      $content = "This message was sent to you trough Cofinder by " .mailButton( $sender->name." ".$sender->surname, Yii::app()->createAbsoluteUrl('/person/view',array('id'=>Yii::app()->user->id)), 'link')

               .$wrapperStart.$_POST['message'].$wrapperEnd
                .mailButton('Reply to this message', Yii::app()->createAbsoluteUrl('/message/view',$replyParams));
                 
      $message->setBody(array("content"=>$content), 'text/html');
      //$message->setBody(array("content"=>$_POST['message'],"senderMail"=>$sender->email), 'text/html');
      
      if (!empty($_POST['project'])){
        //$db_message->idea_to_id = $_POST['project'];
        if (empty($_POST['user'])){
          // send only to project and creator of a project
          $ideaMember = IdeaMember::model()->findByAttributes(array("idea_id"=>$_POST['project'],"type_id"=>1));
          $receiver = User::model()->findByPk($ideaMember->match->user_id);
          
          // add notification to all members
          $ideaMembers = IdeaMember::model()->findAllByAttributes(array("idea_id"=>$_POST['project']));
          foreach ($ideaMembers as $member){
            Notifications::setNotification($member->match->user_id,Notifications::NOTIFY_MESSAGE);
          }

        }else $receiver = User::model()->findByPk($_POST['user']); //reply to person sending to project
        
        $project = IdeaTranslation::model()->findByAttributes(array("idea_id"=>$_POST['project']));
        
        $message_self->subject = "Message send to project";
        $content_self = "You have sent this message trough Cofinder to ".$project->title.  
                  $wrapperStart.$_POST['message'].$wrapperEnd
                   .mailButton('View project', Yii::app()->createAbsoluteUrl('/project/view',array('id'=>$_POST['project']))).' <br />';
                  
      }else{
        //$db_message->user_to_id = $_POST['user'];
        $receiver = User::model()->findByPk($_POST['user']);
        
        $message_self->subject = "Message send to ".$receiver->name." ".$receiver->surname;
        $content_self = "You have sent this message trough Cofinder to ".$receiver->name." ".$receiver->surname.
                   $wrapperStart .$_POST['message'].$wrapperEnd
                  .mailButton('View his profile', Yii::app()->createAbsoluteUrl('/person/view',array('id'=>$receiver->id))).' <br />';
                   
      }
      
      $message->addTo($receiver->email);
      $message->from = Yii::app()->params['adminEmail'];
      Yii::app()->mail->send($message);
      
      
      if (isset($_POST['notify_me']) && $_POST['notify_me'] = 1){
        $message_self->view = 'system';
        // send to self
        $message_self->setBody(array("content"=>$content_self), 'text/html');
        //$message->setBody(array("content"=>$_POST['message'],"senderMail"=>$sender->email), 'text/html');
        $message_self->addTo($sender->email);
        $message_self->from = Yii::app()->params['adminEmail'];
        Yii::app()->mail->send($message_self);
      }
      
      // notify
      setFlash('contactPerson', Yii::t("msg","Your message was sent."));
    }else{
      setFlash('contactPerson', Yii::t("msg","Message can't be empty!"), 'alert');
    }
    
    // go to previous controller
    if (Yii::app()->getBaseUrl()."/index.php" === Yii::app()->user->returnUrl)
      $this->redirect(Yii::app()->controller->module->returnUrl);
    else 
    if (strpos(Yii::app()->request->urlReferrer,"user/login") === false) $this->redirect(Yii::app()->request->urlReferrer);
    else $this->redirect(Yii::app()->user->returnUrl);      
    //goBackController($this);
    //$this->refresh();
	}  

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
  
  public function actionIndex($id = 0, $group = ''){
    Notifications::viewNotification(Notifications::NOTIFY_MESSAGE); //view notifications
    $user_id = Yii::app()->user->id;
    $match = UserMatch::Model()->findByAttributes(array('user_id' => Yii::app()->user->id));
    $ideas = IdeaMember::Model()->findAllByAttributes( array( 'match_id' => $match->id ) );
    $myideaid = '';
    if ($ideas){
      foreach ($ideas as $idea){
        if ($myideaid) $myideaid .= ',';
        $myideaid .= "'".$idea->idea_id."'";
      }
    }
    
    if ($myideaid) $myideaid = "OR idea_to_id IN (".$myideaid.")";
    
    $all_my_msgs = Message::model()->findAll('user_from_id = :myid OR user_to_id = :myid '.$myideaid.' ORDER BY time_sent DESC',
                              array(':myid'=>$user_id));
    
    $msgList = array('users'=>null,'projects'=>null);
    $chatList = array('name'=>'','messages');
    foreach ($all_my_msgs as $msg){
      
      if ($msg->idea_to_id){
        // msg was sent to project
        $ideaTranslation = IdeaTranslation::model()->findByAttributes(array("idea_id"=>$msg->idea_to_id));
        $msgList['projects'][$msg->idea_to_id] = array("id"=>$msg->idea_to_id,
                                    "name"=>trim_text($ideaTranslation->title,40));
        
        if ($id == 0) $id = $msg->idea_to_id;
        if ($group == '') $group = 'project';
        
        if ($group == 'project' && $id == $msg->idea_to_id){
          
          $chatList['name'] = $ideaTranslation->title;
          $chatList['messages'][] = array("from"=>$msg->userFrom->name." ".$msg->userFrom->surname,
                              "from_id"=>$msg->userFrom->id,
                              "avatar_link"=>$msg->userFrom->avatar_link,
                              "time"=>$msg->time_sent,
                              "content"=>$msg->message);
        }
      }else{
        
        if ($msg->user_from_id != $user_id){
          // someone has send me a msg
          $msgList['users'][$msg->user_from_id] = array("id"=>$msg->user_from_id,
                                      "name"=>$msg->userFrom->name." ".$msg->userFrom->surname);
          
          if ($id == 0) $id = $msg->user_from_id;
          if ($group == '') $group = 'user';
          
          if ($group == 'user' && $id == $msg->user_from_id){
            $chatList['name'] = $msg->userFrom->name." ".$msg->userFrom->surname;
            $chatList['messages'][] = array("from"=>$msg->userFrom->name." ".$msg->userFrom->surname,
                                "from_id"=>$msg->userFrom->id,
                                "avatar_link"=>$msg->userFrom->avatar_link,
                                "time"=>$msg->time_sent,
                                "content"=>$msg->message);
          }
        }else{
          // I have send somebody a msg
          $msgList['users'][$msg->user_to_id] = array("id"=>$msg->user_to_id,
                                      "name"=>$msg->userTo->name." ".$msg->userTo->surname);

          if ($id == 0) $id = $msg->user_to_id;
          if ($group == '') $group = 'user';

          if ($group == 'user' && $id == $msg->user_to_id){
            $chatList['name'] = $msg->userTo->name." ".$msg->userTo->surname;
            $chatList['messages'][] = array("from"=>$msg->userFrom->name." ".$msg->userFrom->surname,
                                "from_id"=>$msg->userFrom->id,
                                "avatar_link"=>$msg->userFrom->avatar_link,
                                "time"=>$msg->time_sent,
                                "content"=>$msg->message);
          }
        }
          
      } //end else idea to
    }
    
    $this->render('view',array('id'=>$id,'msgList'=>$msgList,"chatList"=>$chatList,"group"=>$group));
    //print_r($msgList);
    //print_r($chatList);
  }
  
  

	public function actionView($id = 0, $group = '') {
    $this->actionIndex($id, $group);
	}
  
}
