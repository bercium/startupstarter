<?php

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
function isMenuItemActive($action){
  if (is_array($action)){
    foreach ($action as $act)
      if ($act == Yii::app()->controller->action->id) return "active";
  }
  else if ($action == Yii::app()->controller->action->id) return "active";
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
  
  $URL = "maps.googleapis.com/maps/api/staticmap?center=".$address."&zoom=".$zoom."&size=150x150&maptype=roadmap&sensor=true&markers=size:mid|color:blue|".$address;
 
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