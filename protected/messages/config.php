<?php
/**
 * This is the configuration for generating message translations
 * for the Yii framework. It is used by the 'yiic message' command.
 */
return array(
	'sourcePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'messagePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'messages',
	'languages'=>array('blank','sl','hr','es','de'),
	'fileTypes'=>array('php'),
	'overwrite'=>true,
  'sort'=>true,
  'removeOld'=>true,
	'exclude'=>array(
		'.svn',
		'.gitignore',
		'.git',
		'yiilite.php',
		'yiit.php',
		'/i18n/data',
		'/messages',
		'/vendors',
		'/web/js',
		'/extensions/giix-core/',
		'/extensions/giix-components/',
	),
);
