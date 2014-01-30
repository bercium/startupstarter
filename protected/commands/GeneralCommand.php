<?php

class GeneralCommand extends CConsoleCommand{

  
  
  /**
   * inport.io connect function
   */
  private function query($connectorGuid, $input, $userGuid, $apiKey) {

    $url = "https://api.import.io/store/connector/" . $connectorGuid . "/_query?_user=" . urlencode($userGuid) . "&_apikey=" . urlencode($apiKey);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS,  json_encode(array("input" => $input)));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode($result);
  }
  
  /**
   * restoring DB
   */
	public function actionLoadCalendars(){
    $connectorGuid = "6f47b5aa-eac5-4992-9a6b-384ab56266a4";
    $userGuid = "58e3153e-fa36-4b9d-8c4d-b5738a582d87";
    $apiKey = "7dMKDBf9TiWohXjN/uofMZfZ9tubpjPME/iTMgNHYw6LCNq4fweTErAOVE/Q8samc5W2fBFSNXzlUjHGkkzFXQ==";

    $events = array();
    $i = 0;
    
    // Query for tile startup.si
    $result = $this->query($connectorGuid, array(
      "webpage/url" => "http://www.startup.si/sl-si/EventList",
    ), $userGuid, $apiKey);
    //var_dump($result);
    
    foreach ($result->results as $event){
      //$event_tmp['id'] = $i++;
      $event_tmp['title'] = $event->title;
      $event_tmp['content'] = $event->content;
      $event_tmp['location'] = substr($event->location,0,  strpos($event->location, " [ "));
      $event_tmp['link'] = $event->link;
      
      $event_tmp['start'] = $event->date[0]." ".$event->date[1];
      $event_tmp['end'] = $event->date[0]." ".$event->date[1];
      $event_tmp['allday'] = false;
      
      $event_tmp['source'] = "http://www.startup.si/sl-si/EventList";
      
      $events[] = $event_tmp;
    }

    // Query for tile spiritslovenia
    $result = $this->query($connectorGuid, array(
      "webpage/url" => "http://www.spiritslovenia.si/dogodki",
    ), $userGuid, $apiKey);
    //var_dump($result);

    foreach ($result->results as $event){
      //$event_tmp['id'] = $i++;
      $event_tmp['title'] = $event->title;
      $event_tmp['content'] = $event->content;
      $event_tmp['location'] = $event->location;
      $event_tmp['link'] = $event->link;

      $event_tmp['start'] = trim(substr($event->date,0, strpos($event->date, " -")));
      $event_tmp['end'] = trim(substr($event->date,strpos($event->date, "- ")+2));
      $event_tmp['allday'] = true;
      
      $event_tmp['source'] = "http://www.spiritslovenia.si/dogodki";
      
      $events[] = $event_tmp;
    }
    
    $event = array();
    // Query for tile TP
    $result = $this->query($connectorGuid, array(
      "webpage/url" => "http://www.tp-lj.si/dogodki",
    ), $userGuid, $apiKey);
    
    foreach ($result->results as $event){
      //$event_tmp['id'] = $i++;
      $event_tmp['title'] = $event->title;
      $event_tmp['content'] = '';//$event->content;  //problem s contentom
      $event_tmp['location'] = '';//$event->location; // ni lokacije
      $event_tmp['link'] = $event->link;

      $event_tmp['start'] = str_replace("- ","",$event->date);
      $event_tmp['end'] = str_replace("- ","",$event->date);
      $event_tmp['allday'] = false;
      
      $event_tmp['source'] = "http://www.tp-lj.si/dogodki";
      
      $events[] = $event_tmp;
    }
    

    //$events = array();
    // Query for tile racunalniske-novice
    $result = $this->query($connectorGuid, array(
      "webpage/url" => "http://www.racunalniske-novice.com/dogodki/",
    ), $userGuid, $apiKey);
    //var_dump($result);
    foreach ($result->results as $event){
      //$event_tmp['id'] = $i++;
      $event_tmp['title'] = $event->title;
      $event_tmp['content'] = $event->content;  //problem s contentom
      $event_tmp['link'] = $event->link;
      
      $event_tmp['location'] = trim(substr($event->location,  strpos($event->location, ":")+3));

      $event_tmp['allday'] = false;
      if (strpos($event->location, ":")===false){
        $date = substr($event->location, 0, strpos($event->location, " "));
        $event_tmp['allday'] = true;
      }else $date = str_replace(", ob","",substr($event->location, 0, strpos($event->location, ":")+3));
      $event_tmp['start'] = $date;
      $event_tmp['end'] = $date;
      
      $event_tmp['source'] = "http://www.racunalniske-novice.com/dogodki/";
      
      $events[] = $event_tmp;
    }
    
    
    $filename = "calendar.json";
    $folder = Yii::app()->basePath.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR.Yii::app()->params['tempFolder'];

 		if (!is_dir($folder)) {
			mkdir($folder, 0777, true);
		}

    file_put_contents($folder.$filename, json_encode($events));
    
    return 1;
	}
  
  /**
   * Add invites to all users who have less than 2 invites.
   * Give more to the ones that have used more invites.
   * Give more to the ones that have profile filed over certain limit
   */
  public function actionAutoAddInvites(){
    $users = User::model()->findAll("status = :status AND invitations < :invite",array(":status"=>1,":invite"=>2));
    $userStats = UserStat::model()->findAll();
    $stat = array();
    foreach ($userStats as $userStat){
      $stat[$userStat->user_id] = $userStat;
    }
    
    // check all users
    foreach ($users as $user){
      if (!isset($stat[$user->id])){
        // not yet calculated %
        $c = new Completeness();
        $c->setPercentage($user->id);
      }else{
        //percentage in now add invitations
        if ($stat[$user->id]->completeness >= PROFILE_COMPLETENESS_MIN){
          if ($stat[$user->id]->invites_send == 0) $user->invitations +=4; // initial 4+1 invites after profile completed
          $user->invitations++;
        }
        if ($stat[$user->id]->invites_send > 5) $user->invitations+=2;
        if ($stat[$user->id]->invites_registered > 5) $user->invitations++;
        $user->save();      
      }
    }
  }
  
}
