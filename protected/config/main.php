<?php
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../components/functions/global.php');
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'constants.php');
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$a = array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Cofinder',
  'sourceLanguage'=>'en',
  /*'language' => "sl",*/
  //
  'timeZone'=>'GMT',

	// preloading 'log' component
	'preload'=>array(
      'log',
      'EJSUrlManager',
      //'foundation',
  ),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
    'application.components.functions.*',
    'application.components.extenders.*',
    'application.components.behaviours.*',
    'application.components.lib.*',
    'ext.giix-components.*', // giix components
    'application.extensions.auditTrail.models.AuditTrail', // system for loging models
    'application.modules.user.models.*',  // yii-user login system
    'application.modules.user.components.*', // yii-user login system
    'ext.mail.YiiMailMessage', // mail system
    'ext.tinymce.*', //tiny mce
    'ext.JsTrans.*',  // js translate class
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
      'tableUsers' => 'user',
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
      'autoLogin' => false,
      # registration path
      'registrationUrl' => array('/user/registration'),
      # recovery password path
      'recoveryUrl' => array('/user/recovery'),
      # login form path
      'loginUrl' => array('/user/login'),
      # page after login
      'returnUrl' => array('/profile'),
      # page after logout
      'returnLogoutUrl' => array('/site/index'),        
		),
      
    /*'auditTrail'=>array(),*/
	),

	// application components
	'components'=>array(      
    'EJSUrlManager' => array(
      'class' => 'ext.JSUrlManager.src.EJSUrlManager'
    ),
    'clientScript'=>array(
      'coreScriptPosition'=>CClientScript::POS_END,
      'defaultScriptPosition'=>CClientScript::POS_END,
      'defaultScriptFilePosition'=>CClientScript::POS_END,
      'class' => 'ext.yii-eclient-script.EClientScript',
      'combineScriptFiles' => !YII_DEBUG, // By default this is set to true, set this to true if you'd like to combine the script files
      'combineCssFiles' => !YII_DEBUG, // By default this is set to true, set this to true if you'd like to combine the css files
//      'combineScriptFiles' => true, 
//      'combineCssFiles' => true, 
      'optimizeScriptFiles' => true, // @since: 1.1
      'optimizeCssFiles' => false, // @since: 1.1
      'optimizeInlineScript' => false, // @since: 1.6, This may case response slower
      'optimizeInlineCss' => false, // @since: 1.6, This may case response slower
      'saveGzippedCopy' => true,
      //'version' => require(dirname(__FILE__) . '/version.php'),
    ),
    //'foundation' => array("class" => "ext.foundation.components.Foundation"),
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
        /*'list' => array('site/list', 'caseSensitive'=>false),*/
        ''=>'site/index',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<id:\d+>/<lang:\w{2}>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
        array(
          'class' => 'application.components.VanityUrlRule',
          'connectionID' => 'db',
        ),
			),
		),
		
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		'db' => array(
                  'enableProfiling'=>YII_DEBUG,
                  'enableParamLogging'=>YII_DEBUG,
                  'initSQLs'=>array("set time_zone='+00:00';"),
            ),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
      
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					//'class'=>'CWebLogRoute',
					'levels'=>'error, warning, trace, info',
					'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
          'ipFilters'=>array('127.0.0.1'),
          'enabled'=>YII_DEBUG,
				),
        array(
  					'levels'=>'error',
            'class'=>'CEmailLogRoute',
            'emails' => array('dev@cofinder.eu'),
            //'categories' => 'exception.*, system.*',
            'sentFrom'   => 'system@cofinder.eu',
            'subject'    => 'Error on production',
            'utf8' => true,
            'enabled'=>(!YII_DEBUG && !YII_TESTING && ( !(isset(Yii::app()->user) &&  Yii::app()->user->isAdmin())) ),  // send mail only from production
            //'enabled'=>YII_DEBUG,
            /*'categories'=>'system.db.*',*/
            'except'=>'exception.CHttpException.*'
        ),          
        array(
  					'levels'=>'error',
            'class'=>'CFileLogRoute',
            'logFile' => 'application.error.log',
            'enabled'=>!YII_DEBUG,
            //'enabled'=>YII_DEBUG,
            /*'categories'=>'system.db.*',*/
        ),          
        array(
  					'levels'=>'warning',
            'class'=>'CFileLogRoute',
            'logFile' => 'application.warning.log',
            'enabled'=>!YII_DEBUG,
            /*'categories'=>'system.db.*',*/
        ),          
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),*/
				
			),
		),

    'cache' => array (
      'class' => 'CDummyCache', //system.caching.CMemCache
      //'class' => 'CApcCache', //system.caching.CMemCache
      //'class' => 'CMemCache',
      /*'servers'=>array(
          array(
              'host'=>'localhost',
              'port'=>11211,
              ),
          ),*/
    ),
    'mail' => array(
        'class' => 'ext.mail.YiiMail',
        'transportType' => 'php', //smtp
        /*'transportOptions' => array_merge(array(
            'host' => 'smtp.gmail.com',
            'port' => '465',
            'encryption'=>'tls',
          ),require(dirname(__FILE__) . '/local-mail.php')
        ),*/
        'viewPath' => 'application.views.layouts.mail',
        'logging' => YII_DEBUG,
        'dryRun' => YII_DEBUG
    ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
    'version'=>require(dirname(__FILE__) . '/version.php'),
		'adminEmail'=>array('no-reply@cofinder.eu'=>'Cofinder'), //!!! must decide if usefull seperate mail
    'noreplyEmail'=>array('no-reply@cofinder.eu'=>'Cofinder'),
    'teamEmail'=>array('team@cofinder.eu'=>'Cofinder'),
      
    'tempFolder'=>'temp/',
    'avatarFolder'=>'uploads/avatars/',
    'projectGalleryFolder'=>'uploads/project_gallery/', //project ID as subfolder
    'surveyFolder'=>'protected/views/event/', //_survey$event_id.php as filename
    'mapsFolder'=>'uploads/maps/',
    'iconsFolder'=>'uploads/icons/',
    'dbbackup'=>'protected/data/backup/',
	),
);

$b = require(dirname(__FILE__) . '/local-main.php');

return array_merge_recursive_distinct($a,$b);
