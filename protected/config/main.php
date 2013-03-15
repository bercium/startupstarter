<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',
  'sourceLanguage'=>'en',
  'language' => "sl",

	// preloading 'log' component
	'preload'=>array(
      'log',
      'foundation',
  ),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
    'ext.giix-components.*', // giix components
    'application.extensions.auditTrail.models.AuditTrail', // system for loging models
    'application.modules.user.models.*',  // yii-user login system
    'application.modules.user.components.*', // yii-user login system
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'yiigii',
      'generatorPaths' => array(
  			'ext.giix-core', // giix generators
    	),        
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
      
		'user'=>array(
      'tableUsers' => 'users',
      'tableProfiles' => 'profiles',
      'tableProfileFields' => 'profiles_fields',        
      # encrypting method (php hash function)
      'hash' => 'md5',
      # send activation email
      'sendActivationMail' => true,
      # allow access for non-activated users
      'loginNotActiv' => false,
      # activate user on registration (only sendActivationMail = false)
      'activeAfterRegister' => false,
      # automatically login from registration
      'autoLogin' => true,
      # registration path
      'registrationUrl' => array('/user/registration'),
      # recovery password path
      'recoveryUrl' => array('/user/recovery'),
      # login form path
      'loginUrl' => array('/user/login'),
      # page after login
      'returnUrl' => array('/user/profile'),
      # page after logout
      'returnLogoutUrl' => array('/user/login'),        
		),      
      
    /*'auditTrail'=>array(),*/
	),

	// application components
	'components'=>array(
    'foundation' => array("class" => "ext.foundation.components.Foundation"),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
      # encrypting method (php hash function)
      'class'=>"WebUser",
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
      'showScriptName'=>false,
			'rules'=>array(
        'list' => array('site/list', 'caseSensitive'=>false),
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		'db' => require(dirname(__FILE__) . '/local-db.php'),
		/*'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=slocoworking',
			'emulatePrepare' => true,
			'username' => 'startupstarter',
			'password' => 'ss1DBzbj',
			'charset' => 'utf8',
		),
		*/
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);