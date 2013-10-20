<?php


/**
 * append this string to files that you wish to force refresh during version changes
 * it should be used on CSS and JS files that get cached for a long time
 */
function getVersionID(){
  $version = Yii::app()->params['version'];
  
  return "?".substr(md5($version),0,5);
}

/**
 * function to shorten URL with google url shortener
 */
function short_url_google($longUrl) {     
  $GoogleApiKey = 'enter-your-google-api-key-here';     
  $postData = array('longUrl' => $longUrl /*, 'key' => $GoogleApiKey*/);
    $jsonData = json_encode($postData);
    $curlObj = curl_init();
    curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url');
    curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
    //As the API is on https, set the value for CURLOPT_SSL_VERIFYPEER to false. This will stop cURL from verifying the SSL certificate.
    curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curlObj, CURLOPT_HEADER, 0);
    curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
    curl_setopt($curlObj, CURLOPT_POST, 1);
    curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);
    $response = curl_exec($curlObj);
    $json = json_decode($response);
    curl_close($curlObj);
    return $json->id;
}

/**
 * function to shorten URL with bit.ly url shortener
 */
function short_url_bitly($url, $format='txt') {
    $login = "your-bitly-login";
    $appkey = "your-bitly-application-key";
    $bitly_api = 'http://api.bit.ly/v3/shorten?login='.$login.'&apiKey='.$appkey.'&uri='.urlencode($url).'&format='.$format;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$bitly_api);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

/**
 * will return your avatar or defult one
 */
function avatar_image($filename, $userID = 0, $thumb=30){

  if ($thumb) $thumb = "thumb_".$thumb."_";
  else $thumb = '';
  if ($filename){
    //if (file_exists($filename)) return $filename;
    $pathFileName = Yii::app()->params['avatarFolder'].$thumb.$filename;

    if (file_exists(Yii::app()->basePath.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR.$pathFileName)) 
            return Yii::app()->getBaseUrl(true)."/".$pathFileName;
  }
  
  $userID = ($userID % 4); // 3 different default avatars
  return Yii::app()->getBaseUrl(true)."/images/dummy-avatar-".$userID.".png";
//  return Yii::app()->request->baseUrl."/images/dummy-avatar-".$userID.".png";
}

/**
 * check if curent action is active and return apropriate CSS class
 */
function isMenuItemActive($action,$controller = ''){
  if ($controller != '' && $controller != Yii::app()->controller->id) return '';
  if (is_array($action)){
    foreach ($action as $act)
      if ($act == Yii::app()->controller->action->id) return "active";
  }
  else if ($action == Yii::app()->controller->action->id) return "active";
  return '';
}


/**
 * trims text to a space then adds ellipses if desired
 * @param string $input text to trim
 * @param int $length in characters to trim to
 * @param bool $ellipses if ellipses (...) are to be added
 * @param bool $strip_html if html tags are to be stripped
 * @return string 
 */
function trim_text($input, $length, $ellipses = true, $strip_html = true) {
    //strip tags, if desired
    if ($strip_html) {
        $input = strip_tags($input);
    }
  
    //no need to trim, already shorter than trim length
    if (strlen($input) <= $length) {
        return $input;
    }
  
    //find last space within length
    $last_space = strrpos(substr($input, 0, $length), ' ');
    $trimmed_text = substr($input, 0, $last_space);
  
    //add ellipses (...)
    if ($ellipses) {
        $trimmed_text .= '...';
    }
  
    return $trimmed_text;
}

/**
 * 
 */
//if(!class_exists('elhttpclient'));
function getGMap($country = '', $city = '', $addr = ''){
  //include_once "httpclient.php";
	//if(!class_exists('elhttpclient')){
	Yii::import('application.helpers.elHttpClient');
	//}
  $httpClient = new elHttpClient();
  $httpClient->setUserAgent("ff3");
 
  
  $zoom = 0;
  $address = '';
  if ($country){
    $zoom = 3;
    $address = $country;
  }
  if ($city){
    $zoom = 8;
    if ($address) $address .= ', ';
    $address .= $city;
  }
  if ($addr){
    $zoom = 14;
    if ($address) $address .= ', ';
    $address .= $addr;
  }
  if ($zoom == 0) return '';
  
  $URL = "maps.googleapis.com/maps/api/staticmap?center=".$address."&zoom=".$zoom."&size=150x150&maptype=roadmap&sensor=true&markers=size:mid|color:green|".$address;
 
  $filename = $address.".png";
  $folder = Yii::app()->basePath.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR.Yii::app()->params['mapsFolder'];
  
  if (file_exists($folder.$filename)){
    return Yii::app()->getBaseUrl(true)."/".Yii::app()->params['mapsFolder'].$filename;
  }else{
    //$this->buildRequest($URL, 'GET');
    //return $this->fetch($URL);
    $httpClient->setHeaders(array("Accept"=>"text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"));
    //$htmlDataObject = $httpClient->get("maps.googleapis.com");
    $URL = str_replace(" ", "%20", $URL);
    $htmlDataObject = $httpClient->get($URL);
    //change from XML to array
    $htmlData = $htmlDataObject->httpBody;
    
 		if (!is_dir($folder)) {
			mkdir($folder, 0777, true);
		}

    file_put_contents($folder.$filename, $htmlData);
    return Yii::app()->getBaseUrl(true)."/".Yii::app()->params['mapsFolder'].$filename;
  }
}


/**
 * 
 */
//if(!class_exists('elhttpclient'));
function getLinkIcon($link){
  //include_once "httpclient.php";
	//if(!class_exists('elhttpclient')){
	Yii::import('application.helpers.elHttpClient');
	//}
  $httpClient = new elHttpClient();
  $httpClient->setUserAgent("ff3");
 
  $link =  parse_url("http://".remove_http($link), PHP_URL_HOST);
  
  $URL = "http://www.google.com/s2/favicons?domain=".$link;
 
  $filename = $link.".png";
  $folder = Yii::app()->basePath.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR.Yii::app()->params['iconsFolder'];
  
  if (file_exists($folder.$filename)){
    return Yii::app()->getBaseUrl(true)."/".Yii::app()->params['iconsFolder'].$filename;
  }else{
    //$this->buildRequest($URL, 'GET');
    //return $this->fetch($URL);
    $httpClient->setHeaders(array("Accept"=>"text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"));
    //$htmlDataObject = $httpClient->get("maps.googleapis.com");
    $URL = str_replace(" ", "%20", $URL);
    $htmlDataObject = $httpClient->get($URL);
    //change from XML to array
    $htmlData = $htmlDataObject->httpBody;
    
 		if (!is_dir($folder)) {
			mkdir($folder, 0777, true);
		}

    file_put_contents($folder.$filename, $htmlData);
    return Yii::app()->getBaseUrl(true)."/".Yii::app()->params['iconsFolder'].$filename;
  }
}

function add_http($link){
  //return $link;
  if ((strpos($link, "http://") === false) && (strpos($link, "https://") === false)){
    return "http://".$link;
  }
  return $link;
}


/**
 * remove http:// and https://
 */
function remove_http($url) {
   $disallowed = array('http://', 'https://');
   foreach($disallowed as $d) {
      if(strpos($url, $d) === 0) {
         return str_replace($d, '', $url);
      }
   }
   return $url;
}

/**
 * will convert array data into format useful for logging
 */
function arrayLog($data, $space = '&nbsp;&nbsp;'){
	
	$string = '';
  if(is_array($data)){
    foreach ($data as $key => $row){
      if (is_array($row)) $string .= $space."[<strong style='color:#B22;'>".$key."</strong>] => (<br />".arrayLog($row, $space."&nbsp;&nbsp;&nbsp;&nbsp;").$space.")<br />";
      else {
        if (is_numeric($row)) $string .= $space."<strong>".$key."</strong> => <font style='color:#11F'>".$row."</font><br />";
        else $string .= $space."<strong>".$key."</strong> => '".$row."'<br />";
      }
    }
    if ($space == '&nbsp;&nbsp;') $string = "Array data:\n".$string;
  }
  
	return $string;
}


/**
 * dynamicaly translate si
 */
function sifTrans($value){
  return Yii::t("app",$value);
}

/**
 * 
 */
function setFlash($flashName, $flashMessage, $status = 'success', $autoShow = true){
  $flash = array("message"=>$flashMessage, "status"=>$status, "autoShow" => $autoShow);
  Yii::app()->user->setFlash($flashName, $flash);
}

function getFlashData($flashName){
  if(Yii::app()->user->hasFlash($flashName)){
    $flash =  Yii::app()->user->getFlash($flashName);
    return $flash['message'];
  }
  return false;
}


function getFlash($flashName){
  $html = '';
  if(Yii::app()->user->hasFlash($flashName)){
    $flash = Yii::app()->user->getFlash($flashName);
    
    $html .= '<div data-alert class="alert-box radius '.$flash['status'].'">';
    $html .= $flash['message'];
    $html .= '<a href="#" class="close">&times;</a></div>';
  }
  return $html;
}

function writeFlash($flashName){
  echo getFlash($flashName);
}

function writeFlashes(){
  $flashMessages = Yii::app()->user->getFlashes(false);
  if ($flashMessages) {
    $i = 0;
    $hide = '';
    $html = '<div class="row"><div class="flashes">';
    foreach($flashMessages as $key => $flash) {
      if ($flash["autoShow"]){
        Yii::app()->user->getFlash($key);
      
        $html .= '<div data-alert class="alert-box radius '.$flash['status'].' flash-hide-'.$i.' ">';
        $html .= $flash['message'];
        $html .= '<a href="#" class="close">&times;</a></div>';

        if ($flash['status'] != 'alert') $hide .= '$(".flash-hide-'.$i.'").animate({opacity: 1.0}, '.(3000+$i*500).').fadeOut();';
        else $hide .= '$(".flash-hide-'.$i.'").animate({opacity: 1.0}, '.(10000+$i*500).').fadeOut();';
        $i++;
      }
    }
    $html .= '</div></div>';
    if ($i > 0){ 
      echo $html;
      Yii::app()->clientScript->registerScript(
         'myHideEffect',
         $hide,
         CClientScript::POS_READY
      );
    }
  }
}

function goBackController(){
  if (Yii::app()->getBaseUrl()."/index.php" === Yii::app()->user->returnUrl)
    $this->redirect(Yii::app()->controller->module->returnUrl);
  else 
    if (strpos(Yii::app()->request->urlReferrer,"user/login") === false) $this->redirect(Yii::app()->request->urlReferrer);
    else $this->redirect(Yii::app()->user->returnUrl);  
}