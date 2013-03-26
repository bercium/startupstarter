<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),
    
  'modules'=>array(
      'user'=>array(
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
  ),
	// application components
	'components'=>array(
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
        'transportType' => 'smtp',
        'transportOptions' => array(
            'host' => 'smtp.gmail.com',
            'username' => 'bercium@gmail.com',
            'password' => 'tuki1oplelismo',
            'port' => '465',
            'encryption'=>'tls',
        ),
        'viewPath' => 'application.views.mailTemplates',
        'logging' => true,
        'dryRun' => false
    ),      
	),
);
