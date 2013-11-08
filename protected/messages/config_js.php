<?php
/**
 * This is the configuration for generating message translations
 * for the Yii framework. It is used by the 'yiic message' command.
 */
return array(
	'sourcePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR."..",
	'messagePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'messages',
  'translator' => 'Yii.t',
	'languages'=>array('blank','sl'),
	'fileTypes'=>array('js'),
	'overwrite'=>true,
  'sort'=>true,
  /*'removeOld'=>true,*/
	'exclude'=>array(
		'.svn',
		'.gitignore',
		'.git',
		'yiilite.php',
		'yiit.php',
		'/protected/i18n/data',
		'/protected/messages',
		'/protected/vendors',
		//'/web/js',
		'/protected/extensions/giix-core/',
		'/protected/extensions/giix-components/',
    '/protected/extensions/tinymce/',
    '/nbproject/',
    '/assets/',
    '/themes/',
    '/uploads/',
    '/temp/',
	),
);
