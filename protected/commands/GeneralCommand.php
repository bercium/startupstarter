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
   * search for city and country from location
   */
  function getCityAndCountry($location){
    if ($location == '') return array('city'=>'', 'country'=>'');
    
    $e = Event::model()->findByAttributes(array("location"=>$location));
    if ($e){
      if ($e->country && $e->city) return array('city'=>$e->city, 'country'=>$e->country);
    }
    
    $location = str_ireplace("zda", "", $location);
    
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($location).'&sensor=false';
    $httpClient = new elHttpClient();
    $httpClient->setUserAgent("ff3");
    $httpClient->setHeaders(array("Accept"=>"text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"));
    $htmlDataObject = $httpClient->get($url);
    $result = $htmlDataObject->httpBody;
    
    $result = json_decode($result);
    
    $country = '';
    $city = '';
    
    if ($result->status == 'OK'){
      if (isset($result->results[0]->address_components)){
        $components = $result->results[0]->address_components;
        foreach ($components as $component){
          if ($component->types[0] == 'country'){
            $country = $component->long_name;
          }
          //if ($component->types[0] == 'postal_town'){
          if ($component->types[0] == 'locality'){
            $city = $component->long_name;
          }
        }
      }
    }else{
      return array('city'=>'', 'country'=>'');
      //die(print_r($result,true));
    }
    
    //die($city."-".$country." | ".print_r($result,true));
    return array('city'=>$city, 'country'=>$country);
  }
  
  
  function saveGcal($response, $source){
 // our google calendar
    if (isset($response['events'])){
      foreach ($response['events'] as $event){
        $content = $event['description'];
        
        // set color from content
        $event_tmp['color'] = "";
        if (strpos($content,"#red")){
          $content = str_replace("#red", "", $content);
          $event_tmp['color'] = "red";
        }
        if (strpos($content,"#blue")){
          $content = str_replace("#blue", "", $content);
          $event_tmp['color'] = "blue";
        }
        if (strpos($content,"#green")) $content = str_replace("#green", "", $content); // just fallback
        
        $link = '';
        // set links from content
        if (strpos($content,"#link:")){
          if (strpos($content,"\n",strpos($content,"#link:")) === false){
            $link = substr($content, strpos($content,"#link:"), strlen($content));
          }else $link = substr($content, strpos($content,"#link:"), strpos($content,"\n",strpos($content,"#link:")));
          $content = str_replace($link, "", $content);
          $link = trim(str_replace("#link:", "", $link));
        }

        $event_tmp['title'] = $event['title'];
        $event_tmp['content'] = trim_text(str_replace("\n", "<br />", trim($content)),1500,true,false);
        $event_tmp['location'] = $event['location'];
        $event_tmp['link'] = $link;

        $start = strtotime($event["start"])+1*60*60;
        $end = strtotime($event["end"])+1*60*60;
        
        $event_tmp['start'] = date("c",$start);
        $event_tmp['end'] = date("c",$end);

        $event_tmp['allday'] = false;
        if (timeDifference($start, $end, "days_total") >= 1){
          $event_tmp['allday'] = true;
        }

        $event_tmp['source'] = $source;
        
        $this->saveEventToDb($event_tmp);
      }
    }    
  }
  
  /**
   * check if event exits end if not save it
   */
  function saveEventToDb($event){
    // TODO: get city and country
    
    if ($event['start']) $event['start'] = date('Y-m-d H:i:s',strtotime($event['start']));
    if ($event['end']) $event['end'] = date('Y-m-d H:i:s',strtotime($event['end']));
    
    $e = Event::model()->findByAttributes(array("title"=>$event['title'],"start"=>$event['start']));    
    
    // check if exist in DB
    if ($e){
      $old_val = (!empty($e->content)) + (!empty($e->location)) + (!empty($e->link));
      $new_val = (!empty($event['content'])) + (!empty($event['location'])) + (!empty($event['link']));      
      // our events have priority or if new event has more variables :) or if the same source (might be updated)
      if ((($e->source != 'http://www.cofinder.eu') && (($event['source'] == 'http://www.cofinder.eu') || ($old_val < $new_val)) )
           || ($e->source == $event['source'])){
        $e->title = $event['title'];
        $e->start = $event['start'];
        $e->end = $event['end'];
        if ($event['allday']) $e->all_day = 1;
        else $e->all_day = 0;
        if (isset($event['content'])) $e->content = $event['content'];
        if (isset($event['link'])) $e->link = $event['link'];
        if (isset($event['location'])){
          $e->location = $event['location'];
          $cityCountry = $this->getCityAndCountry($event['location']);
          $e->city = $cityCountry['city'];
          $e->country = $cityCountry['country'];
        }
        if (isset($event['source'])) $e->source = $event['source'];
        if (isset($event['color'])) $e->color = $event['color'];
        if (!$e->save());// die(print_r($e->errors));
      }
    }else{
      $e = new Event();
      $e->title = $event['title'];
      $e->start = $event['start'];
      $e->end = $event['end'];
      if ($event['allday']) $e->all_day = 1;
      else $e->all_day = 0;
      if (isset($event['content'])) $e->content = $event['content'];
      if (isset($event['link'])) $e->link = $event['link'];
      if (isset($event['location'])){
        $e->location = $event['location'];
        $cityCountry = $this->getCityAndCountry($event['location']);
        $e->city = $cityCountry['city'];
        $e->country = $cityCountry['country'];
      }
      if (isset($event['source'])) $e->source = $event['source'];
      if (isset($event['color'])) $e->color = $event['color'];
      //$e->city = $event['title'];
      //$e->country = $event['title'];
      if (!$e->save());// die(print_r($e->errors));
    }
  }
  
  
  /**
   * which event to push
   */
  function compareEvents($old, $new){
    $old_val = (!empty($old['content'])) + (!empty($old['location'])) + (!empty($old['link']));
    $new_val = (!empty($new['content'])) + (!empty($new['location'])) + (!empty($new['link']));
    
    if ($old_val > $new_val) return $old;
    else return $new;
  }
  
  /**
   * restoring DB
   */
	public function actionLoadCalendars(){
    $connectorGuid = "6f47b5aa-eac5-4992-9a6b-384ab56266a4";
    $userGuid = "58e3153e-fa36-4b9d-8c4d-b5738a582d87";
    $apiKey = "7dMKDBf9TiWohXjN/uofMZfZ9tubpjPME/iTMgNHYw6LCNq4fweTErAOVE/Q8samc5W2fBFSNXzlUjHGkkzFXQ==";

    $events = array();
    $eventKeys = array();
    $i = 0;
    
    // Query for tile startup.si
    $result = $this->query($connectorGuid, array(
      "webpage/url" => "http://www.startup.si/sl-si/EventList",
    ), $userGuid, $apiKey);
    //var_dump($result);
    
    foreach ($result->results as $event){
      //$event_tmp['id'] = $i++;
      $event_tmp['title'] = $event->title;
      $event_tmp['content'] = str_replace("\n", "<br />", $event->content);
      $event_tmp['location'] = substr($event->location,0,  strpos($event->location, " [ "));
      $event_tmp['link'] = $event->link;
      
      $event_tmp['start'] = $event->date[0]." ".$event->date[1];
      $event_tmp['end'] = $event->date[0]." ".$event->date[1];
      $event_tmp['allday'] = false;
      
      $event_tmp['source'] = "http://www.startup.si/sl-si/EventList";
      
      $this->saveEventToDb($event_tmp);
      //remove duplicates
      $key = $event_tmp['title'].$event_tmp['start'];
      if (isset($eventKeys[$key])){
        $events[$eventKeys[$key]] = $this->compareEvents($eventKeys[$key], $event_tmp);
      }else{
        $eventKeys[$key] = count($events);
        $events[] = $event_tmp;
      }
    }

    // Query for tile spiritslovenia
    $result = $this->query($connectorGuid, array(
      "webpage/url" => "http://www.spiritslovenia.si/dogodki",
    ), $userGuid, $apiKey);
    //var_dump($result);

    foreach ($result->results as $event){
      //$event_tmp['id'] = $i++;
      $event_tmp['title'] = $event->title;
      $event_tmp['content'] = str_replace("\n", "<br />", $event->content);
      $event_tmp['location'] = $event->location;
      $event_tmp['link'] = $event->link;

      $event_tmp['start'] = trim(substr($event->date,0, strpos($event->date, " -")));
      $event_tmp['end'] = trim(substr($event->date,strpos($event->date, "- ")+2));
      $event_tmp['allday'] = true;
      
      $event_tmp['source'] = "http://www.spiritslovenia.si/dogodki";
      
      $this->saveEventToDb($event_tmp);
      //remove duplicates
      $key = $event_tmp['title'].$event_tmp['start'];
      if (isset($eventKeys[$key])){
        $events[$eventKeys[$key]] = $this->compareEvents($eventKeys[$key], $event_tmp);
      }else{
        $eventKeys[$key] = count($events);
        $events[] = $event_tmp;
      }
    }
    
    $event = array();
    // Query for tile TP
    $result = $this->query($connectorGuid, array(
      "webpage/url" => "http://www.tp-lj.si/dogodki",
    ), $userGuid, $apiKey);
    
    foreach ($result->results as $event){
      //$event_tmp['id'] = $i++;
      $event_tmp['title'] = $event->title;
      $event_tmp['content'] = str_replace("\n", "<br />", $event->content);  //problem s contentom
      $event_tmp['location'] = '';//$event->location; // ni lokacije
      $event_tmp['link'] = $event->link;

      $event_tmp['start'] = str_replace("- ","",$event->date);
      $event_tmp['end'] = str_replace("- ","",$event->date);
      $event_tmp['allday'] = false;
      
      $event_tmp['source'] = "http://www.tp-lj.si/dogodki";

      $this->saveEventToDb($event_tmp);
      //remove duplicates
      $key = $event_tmp['title'].$event_tmp['start'];
      if (isset($eventKeys[$key])){
        $events[$eventKeys[$key]] = $this->compareEvents($eventKeys[$key], $event_tmp);
      }else{
        $eventKeys[$key] = count($events);
        $events[] = $event_tmp;
      }
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
      $event_tmp['content'] = str_replace("\n", "<br />", $event->content);  //problem s contentom
      if (isset($event->link)) $event_tmp['link'] = $event->link;
      else $event_tmp['link'] = '';
      
      $event_tmp['location'] = trim(substr($event->location,  strpos($event->location, ":")+3));

      $event_tmp['allday'] = false;
      if (strpos($event->location, ":")===false){
        $date = substr($event->location, 0, strpos($event->location, " "));
        $event_tmp['allday'] = true;
      }else $date = str_replace(", ob","",substr($event->location, 0, strpos($event->location, ":")+3));
      $event_tmp['start'] = $date;
      $event_tmp['end'] = $date;
      
      $event_tmp['source'] = "http://www.racunalniske-novice.com/dogodki/";
      
      $this->saveEventToDb($event_tmp);
      //remove duplicates
      $key = $event_tmp['title'].$event_tmp['start'];
      if (isset($eventKeys[$key])){
        $events[$eventKeys[$key]] = $this->compareEvents($eventKeys[$key], $event_tmp);
      }else{
        $eventKeys[$key] = count($events);
        $events[] = $event_tmp;
      }
    }
    
    //$events = array();
    // Query for tile racunalniske-novice
    $result = $this->query($connectorGuid, array(
      "webpage/url" => "http://www.racunalniske-novice.com/dogodki/iskalnik/?em/listaj-arhiv/1/",
    ), $userGuid, $apiKey);
    //var_dump($result);
    foreach ($result->results as $event){
      //$event_tmp['id'] = $i++;
      $event_tmp['title'] = $event->title;
      $event_tmp['content'] = str_replace("\n", "<br />", $event->content);  //problem s contentom
      if (isset($event->link)) $event_tmp['link'] = $event->link;
      else $event_tmp['link'] = '';
      
      $event_tmp['location'] = trim(substr($event->location,  strpos($event->location, ":")+3));

      $event_tmp['allday'] = false;
      if (strpos($event->location, ":")===false){
        $date = substr($event->location, 0, strpos($event->location, " "));
        $event_tmp['allday'] = true;
      }else $date = str_replace(", ob","",substr($event->location, 0, strpos($event->location, ":")+3));
      $event_tmp['start'] = $date;
      $event_tmp['end'] = $date;
      
      $event_tmp['source'] = "http://www.racunalniske-novice.com/dogodki/";
      
      $this->saveEventToDb($event_tmp);
      //remove duplicates
      $key = $event_tmp['title'].$event_tmp['start'];
      if (isset($eventKeys[$key])){
        $events[$eventKeys[$key]] = $this->compareEvents($eventKeys[$key], $event_tmp);
      }else{
        $eventKeys[$key] = count($events);
        $events[] = $event_tmp;
      }
    }
    
    
    // OUR GOOGLE CALENDAR
    Yii::import('application.extensions.EGCal.EGCal');
    $cal = new EGCal('', ''); // public calendar
    
    $response = $cal->find(
        array(
            //'min'=>date('c', strtotime(date("d.m.Y"))),
            //'max'=>date('c', strtotime(date("d.m.Y"))),
            'min'=>date("Y-m-1").'T00:00:00+00:00',
            'max'=>date("Y-m-d",strtotime(date("Y-m-1"))+60*60*24*92).'T23:59:00+00:00', //3 months
            'limit'=>50,
            'order'=>'a',
            'calendar_id'=>'1b6ekrafhb0l2mrq86pq5fdov8@group.calendar.google.com',
        )
    );
    
    $this->saveGcal($response, 'http://www.cofinder.eu');
    
    
    // silicon gardens
    /*$response = $cal->find(
        array(
            //'min'=>date('c', strtotime(date("d.m.Y"))),
            //'max'=>date('c', strtotime(date("d.m.Y"))),
            'min'=>date("Y-m-1").'T00:00:00+00:00',
            'max'=>date("Y-m-d",strtotime(date("Y-m-1"))+60*60*24*92).'T23:59:00+00:00', //3 months
            'limit'=>50,
            'order'=>'a',
            'calendar_id'=>'occfrr8e7rtdo46b8k0ibhndtg%40group.calendar.google.com',  // silicon gardens
        )
    );
    
    $this->saveGcal($response, 'http://www.silicongardens.si');*/
    
   
    
    
    //CF event
      //$event_tmp['id'] = $i++;
      /*$event_tmp['title'] = "Sestavi svojo ekipo";
      $event_tmp['content'] = 'Prekipevaš od poslovnih idej in iščeš soustanovitelja ali pa imaš pa željo po nečem novem; pridružiti se super projektu. Pridi na dogodek in spoznal boš cel kup zanimivih ljudi in slišal nore ideje.';
      $event_tmp['location'] = 'Hekovnik, Teslova ulica 30, Ljubljana';//$event->location; // ni lokacije
      $event_tmp['link'] = "http://www.cofinder.eu/events/sestavi-svojo-ekipo/";

      $event_tmp['start'] = "28.2.2014 17:00";
      $event_tmp['end'] = "28.2.2014 21:00";
      $event_tmp['color'] = "red";
      $event_tmp['allday'] = false;
      
      $event_tmp['source'] = "http://www.cofinder.eu";
      
      $events[] = $event_tmp;*/
    
    // write events
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
  
  /**
   * daily projects
   */
  public function actionDailyProjectsPost(){
    
    $projects = Idea::model()->findAll('time_registered >= DATE_ADD(CURDATE(), INTERVAL -1 DAY);');
    
    if ($projects){
      $message_ifttt = new YiiMailMessage;
      $message_ifttt->view = 'none';
      $message_ifttt->subject = "IFTTT: Cofinder project";
      // $message_ifttt->subject = "Na Cofinder TEST imamo nov projekt z imenom '".$translation->title."'.";
      $message_ifttt->from = Yii::app()->params['adminEmail'];

      $i = 0;
      $content_self = '';
      if (count($projects) > 1) $content_self = "Na Cofinderju imamo nekaj novih projektov! <br /><br />'";
      foreach ($projects as $idea){
        $i++;
        $title = '';
        foreach ($idea->ideaTranslations as $pt){
          $title = $pt->title;
          break;
        }
        
        $openPositions = count(IdeaMember::model()->findAllBySql("SELECT * FROM idea_member WHERE idea_id = :id AND type_id = 3 GROUP BY match_id",array(":id"=>$idea->id)));
        
        if (count($projects) == 1){
          $content_self .= "Na Cofinderju imamo nov projekt z imenom '".$title;
          if ($openPositions == 0);
          else
          if ($openPositions == 1) $content_self .= ", ki išče eno osebo za sodelovanje";
          else
          if ($openPositions == 2) $content_self .= ", ki išče dve osebi za sodelovanje";
          else
          if ($openPositions < 5) $content_self .= ", ki išče ".$openPositions." osebe za sodelovanje";
          else
          $content_self .= ", ki išče ".$openPositions." oseb za sodelovanje";
            
          $content_self .= "'. Več o projektu na ".Yii::app()->request->hostInfo.'/project/view?id='.$idea->id;
          break;
        }
        else{
          
          $content_self .= $title;
          if ($openPositions == 0);
          else
          if ($openPositions == 1) $content_self .= ", ki išče eno osebo za sodelovanje";
          else
          if ($openPositions == 2) $content_self .= ", ki išče dve osebi za sodelovanje";
          else
          if ($openPositions < 5) $content_self .= ", ki išče ".$openPositions." osebe za sodelovanje";
          else
          $content_self .= ", ki išče ".$openPositions." oseb za sodelovanje";
          
          $content_self .= "'. Več o projektu na ".Yii::app()->request->hostInfo.'/project/view?id='.$idea->id."<br />";
        }
        
        if ($i > 4) break;
      }

      $message_ifttt->setBody(array("content"=>$content_self), 'text/html');
      $message_ifttt->setTo("bercium@gmail.com");
      Yii::app()->mail->send($message_ifttt);
    }
  }
  
}
