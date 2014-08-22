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
  
  /**
   * 
   */
  private function getLocation($country, $city, $count, $country_id, $city_id){
    $address = urlencode($city.','.$country);

    $httpClient = new elHttpClient();
    $httpClient->setUserAgent("ff3");
    $httpClient->setHeaders(array("Accept"=>"text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"));

    $htmlDataObject = $httpClient->get("http://maps.googleapis.com/maps/api/geocode/json?address={$address}&sensor=false");


    $data = json_decode($htmlDataObject->httpBody);

    //insert location to db
    $location = new Location;
    $location->country_id = $country_id;
    $location->city_id = $city_id;
    $location->lat = $data->results['0']->geometry->location->lat;
    $location->lng = $data->results['0']->geometry->location->lng;
    $location->count = $count;

    $location->save();

    return array("lat"=>$data->results['0']->geometry->location->lat, "lng"=>$data->results['0']->geometry->location->lng);
  }
  
	public function actionIndex(){
		//cross check location & country + city for missing items
		$sql = "SELECT co.id AS country_id, co.name AS country, ci.id AS city_id, ci.name AS city, COUNT(m.id) AS count
            FROM `user_match` AS m 
            LEFT JOIN `country` AS co ON co.id = m.country_id
            LEFT JOIN `city` AS ci ON ci.id = m.city_id
            WHERE m.user_id > 0 AND (co.name IS NOT NULL OR ci.name IS NOT NULL) GROUP BY co.name, ci.name
            ORDER BY count DESC";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$arrayCountryCity = array();

		while(($row=$dataReader->read())!==false) {

			$location = Location::model()->findByAttributes(array('country_id'=>$row['country_id'],'city_id'=>$row['city_id']));
			if($location){
        $row['lat'] = $location->lat;
        $row['lng'] = $location->lng;
				if($row['count'] != $location->count){
					//location has been geocoded and saved to db already. update location's count
					$location->count = $row['count'];
					$location->save();
				}
			} else {
        
        $latlong = $this->getLocation($row['country'], $row['city'], $row['count'], $row['country_id'], $row['city_id']);
        
        $row['lat'] = $latlong['lat'];
        $row['lng'] = $latlong['lng'];
				//}
			}

      if (empty($row['lat']) || empty($row['lng'])) continue;
      
			//build name
			$location_array = array();
			if(strlen($row['city']) > 0){
				$location_array[] = $row['city'];
			}
			if(strlen($row['country']) > 0){
				$location_array[] = $row['country'];
			}
			$row['name'] = implode(', ', $location_array);
			$arrayCountryCity[] = $row;
		}
    
    $arrayCountry = array();
    
    
    // get data for countries only
    $sql = "SELECT co.id AS country_id, co.name AS country, COUNT(m.id) AS count
            FROM `user_match` AS m 
            LEFT JOIN `country` AS co ON co.id = m.country_id
            WHERE m.user_id > 0 AND co.name IS NOT NULL 
            GROUP BY co.name
            ORDER BY count DESC";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$arrayCountry = array();

		while(($row=$dataReader->read())!==false) {

			$location = Location::model()->findByAttributes(array('country_id'=>$row['country_id'],'city_id'=>null));
			if($location){
        $row['lat'] = $location->lat;
        $row['lng'] = $location->lng;
      }else{
        $latlong = $this->getLocation($row['country'], null, $row['count'], $row['country_id'], null);
        
        $row['lat'] = $latlong['lat'];
        $row['lng'] = $latlong['lng'];
				//}
			}
      
      if (empty($row['lat']) || empty($row['lng'])) continue;

			$row['name'] = $row['country'];
			$arrayCountry[] = $row;
		}
    

    $this->render('index', array('data' => $arrayCountryCity, "map_countries"=>$arrayCountry));
 	}
	
}
