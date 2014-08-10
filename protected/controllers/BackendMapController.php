<?php

class BackendMapController extends Controller
{
  public $layout="//layouts/blank";
  
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
			array('allow', // allow admins only
				'users'=>Yii::app()->getModule('user')->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
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
  
	public function actionIndex(){
		//cross check location & country + city for missing items
		$sql = "SELECT co.id AS country_id, co.name AS country, ci.id AS city_id, ci.name AS city, COUNT(m.id) AS count ".
		"FROM `user_match` AS m LEFT JOIN `country` AS co ON co.id = m.country_id ".
		"LEFT JOIN `city` AS ci ON ci.id = m.city_id ".
		"WHERE m.user_id > 0 AND (co.name IS NOT NULL OR ci.name IS NOT NULL) GROUP BY co.name, ci.name ".
		"ORDER BY count DESC";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$array = array();

		while(($row=$dataReader->read())!==false) {

			$location = Location::model()->findByAttributes(array('country_id'=>$row['country_id'],'city_id'=>$row['city_id']));
			if($location){
				if($row['count'] != $location->count){
					//location has been geocoded and saved to db already. update location's count
					$location->count = $row['count'];
					$location->save();
				}
			} else {
				//run geocoding
				$location_array = array();
				if(strlen($row['city']) > 0){
					$location_array[] = $row['city'];
				}
				if(strlen($row['country']) > 0){
					$location_array[] = $row['country'];
				}
				$address = urlencode(implode(',', $location_array));

				$httpClient = new elHttpClient();
				$httpClient->setUserAgent("ff3");
				$httpClient->setHeaders(array("Accept"=>"text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"));

				if($htmlData = $httpClient->get("http://maps.googleapis.com/maps/api/geocode/json?address={$address}&sensor=false")){
					//function getGMap($country = '', $city = '', $addr = ''){
					//$httpClient = new elHttpClient();
					//$httpClient->setUserAgent("ff3");
				    //$httpClient->setHeaders(array("Accept"=>"text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"));
				    //$htmlDataObject = $httpClient->get("maps.googleapis.com"); ISTA KOT 2 KASNEJE
				    //$URL = str_replace(" ", "%20", $URL); //tega nerabiš zaradi lepih podatkov
				    //$htmlDataObject = $httpClient->get($URL);
			    	//$htmlData = $htmlDataObject->httpBody;

			    	//ADMIN site/link POLINKAJ ŠIT -> za vse bazične funkcije tutoriale spisat
			    	//

					$data = json_decode($htmlData);

					//insert location to db
			      	$location = new Location;
			      	$location->country_id = $row['country_id'];
			      	$location->city_id = $row['city_id'];
			      	$location->lat = $data->results['0']->geometry->location->lat;
			      	$location->lng = $data->results['0']->geometry->location->lng;
			      	$location->count = $row['count'];
					$location->save();
				}
			}

			$row['lat'] = $location->lat;
			$row['lng'] = $location->lng;

			//build name
			$location_array = array();
			if(strlen($row['city']) > 0){
				$location_array[] = $row['city'];
			}
			if(strlen($row['country']) > 0){
				$location_array[] = $row['country'];
			}
			$row['name'] = implode(', ', $location_array);
			$array[] = $row;
		}

    	$this->render('index', array('data' => $array));
 	}
	
}
