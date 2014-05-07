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
			array('allow', // allow admin user to perform actions:
				'actions'=>array('index'),
				'users'=>Yii::app()->getModule('user')->getAdmins(),
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
		$sql = "SELECT co.name AS country, ci.name AS city, COUNT(m.id) AS count ".
		"FROM `user_match` AS m LEFT JOIN `country` AS co ON co.id = m.country_id ".
		"LEFT JOIN `city` AS ci ON ci.id = m.city_id WHERE m.user_id > 0 AND (co.name IS NOT NULL OR ci.name IS NOT NULL) GROUP BY co.name, ci.name";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$array = array();

		while(($row=$dataReader->read())!==false) {
			$array[] = $row;
		}

    	$this->render('index', array('data' => $array));
 	}
	
}
