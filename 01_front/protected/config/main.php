<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'AdminPL',
    'theme' => 'strongly',
    'defaultController' => 'site',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.widgets.*',
        'application.vendors.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'`',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
        'account',

	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format

		'urlManager'=>require(dirname(__FILE__) . '/urlManager/urlManager.php'),

        'viewRenderer' => array(
            'class' => 'ext.PHPTALViewRenderer',
            'fileExtension' => '.html',
        ),

        'picasaPhoto' => array(
            'class' => 'ext.PicasaWebEXT',
        ),

		// uncomment the following to use a MySQL database
        'db'=> require(dirname(__FILE__) . '/database/sfp_service_staff.php'),
        'dbSetting'=> require(dirname(__FILE__) . '/database/sfp_service_setting.php'),
        'dbSession'=> require(dirname(__FILE__) . '/database/sfp_service_session.php'),

        'session'=>array(
            'autoStart' => true,
            'class'=>'CDbHttpSession',
            'sessionTableName'=>'sessions',
            'connectionID'=>'dbSession',
        ),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'admin/error',
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
    'params'=>require(dirname(__FILE__) . '/params/params.php'),
);