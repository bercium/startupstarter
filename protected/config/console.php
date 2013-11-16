<?php

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
        'viewPath' => 'application.views.mailTemplates',
        'logging' => true,
        'dryRun' => true
    ),   
	),
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>array('no-reply@cofinder.eu'=>'Cofinder'), //!!! must decide if usefull seperate mail
    'noreplyEmail'=>array('no-reply@cofinder.eu'=>'Cofinder'),
    'tempFolder'=>'temp/',
    'avatarFolder'=>'uploads/avatars/',
    'mapsFolder'=>'uploads/maps/',
	),    
);
