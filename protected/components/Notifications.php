<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Notifications{
  
  private $details = array();
  
  const NOTIFY_MESSAGE = 1;
  const NOTIFY_PROJECT_INVITE = 2;
  const NOTIFY_INVISIBLE = 3;

  
  /**
   * init all details and return them in array
   */
  public function init($user_id = null){    //$value = Yii::app()->cache->get("cacheNotifications");
    
  }
  
  /**
   * get all notification
   */
  public static function getNotifications(){
    //$value = Yii::app()->cache->get("cacheNotifications");
    //if($value === false){
    $notifications = array();
   /* Yii::log(Yii::app()->user->name.", ".Yii::app()->user->isGuest.": ".json_encode(Yii::app()->user), CLogger::LEVEL_INFO, 'custom.info.user');
    $value = Invite::model()->countByAttributes(array(),"(receiver_id = :idReceiver OR email LIKE :email) AND NOT ISNULL(idea_id)",array(":idReceiver"=>Yii::app()->user->id,":email"=>Yii::app()->user->email));
    if ($value){
      $notifications[] = array('count'=>$value,'message'=>self::NOTIFY_PROJECT_INVITE);
    }*/
    //return $notifications;
      //Yii::app()->cache->set("cacheNotifications", $value, 30);
    //}
		$notif=Yii::app()->db->createCommand("SELECT type,COUNT(*) AS c FROM notification WHERE user_id = ".Yii::app()->user->id." AND viewed = 0 GROUP BY type")->queryAll();
    
    foreach ($notif as $n){
      
      switch ($n['type']){
        case self::NOTIFY_MESSAGE: 
            $msg = Yii::t('app','New message|New messages',array($n['c'])); 
            $link = Yii::app()->createUrl('message');
          break;
        case self::NOTIFY_PROJECT_INVITE: 
            $msg = Yii::t('app','Invitation to join a project|Invitations to join a project',array($n['c'])); 
            $link = Yii::app()->createUrl('profile/notification');
          break;
        case self::NOTIFY_INVISIBLE: 
            $msg = Yii::t('msg','Your profile is not visible to the public.'); 
            $link = '';
          break;
      }
      $notifications[] = array('count'=>$n['c'],'message'=>$msg,'link'=>$link, 'type'=>$n['type']);
    }
    
    return $notifications;
  }
  
  /**
   * get only percentage
   */
  public static function setNotification($user_id, $notification){
    $notify = new Notification();
    $notify->user_id = $user_id;
    $notify->type = $notification;
    $notify->save();
  }
  
  /**
   * get only percentage
   */
  public static function viewNotification($notification){
    $notify = Notification::model()->findAllByAttributes(array("user_id"=>Yii::app()->user->id,"type"=>$notification,"viewed"=>0));
    foreach ($notify as $n){
      $n->viewed = 1;
      $n->save();
    }
  }
}