<?php
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'constants.php');

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Cofinder console application',

	// preloading 'log' component
	'preload'=>array('log'),
    
	'import'=>array(
		'application.models.*',
		'application.components.*',
    'ext.giix-components.*', // giix components
    'application.extensions.auditTrail.models.AuditTrail', // system for loging models
    'application.modules.user.models.*',  // yii-user login system
    'application.modules.user.components.*', // yii-user login system
    'ext.mail.YiiMailMessage', // mail system
    'ext.tinymce.*', //tiny mce
	),    
    
  'modules'=>array(
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
      'autoLogin' => true,
      # registration path
      'registrationUrl' => array('/user/registration'),
      # recovery password path
      'recoveryUrl' => array('/user/recovery'),
      # login form path
      'loginUrl' => array('/user/login'),
      # page after login
      'returnUrl' => array('/profile'),
      # page after logout
      'returnLogoutUrl' => array('/user/login'),        
		), 
  ),
	// application components
	'components'=>array(
    'request' => require(dirname(__FILE__) . '/local-console-request.php'),
      
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		
    'db' => require(dirname(__FILE__) . '/local-db.php'),
		
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
          'logFile' => 'console.log',
				),
			),
		),

    'mail' => array(
        'class' => 'ext.mail.YiiMail',
        'transportType' => 'php',
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
	'params'=>array(
		// this is used in contact page
    'version'=>require(dirname(__FILE__) . '/version.php'),
		'adminEmail'=>array('no-reply@cofinder.eu'=>'Cofinder'), //!!! must decide if usefull seperate mail
    'noreplyEmail'=>array('no-reply@cofinder.eu'=>'Cofinder'),
    'teamEmail'=>array('team@cofinder.eu'=>'Cofinder'),
      
    'tempFolder'=>'temp/',
    'avatarFolder'=>'uploads/avatars/',
    'ideaGalleryFolder'=>'uploads/ideagalleries/',
    'mapsFolder'=>'uploads/maps/',
    'iconsFolder'=>'uploads/icons/',
    'dbbackup'=>'protected/data/backup/',
	),    
);
