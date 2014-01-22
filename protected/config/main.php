<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/yiibooster-2.1.1');
Yii::setPathOfAlias('application.migrations', dirname(__FILE__).'/../migrations');


return array(
    'theme' => 'bootstrap',
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Помощь на дорогах',
    'sourceLanguage'=>'en_US',
    'language'=>'ru',
    'charset'=>'utf-8',
    'timeZone'=>'GMT',
	// preloading 'log' component
	'preload'=>array('log','bootstrap'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
    ),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
//			'ipFilters'=>array('127.0.0.1','::1'),
            'generatorPaths' => array(
                'bootstrap.gii',
            ),
		),

	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
        'bootstrap'=>array(
            'class'=>'bootstrap.components.Bootstrap',
        ),

        // uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
//            'showScriptName' => false,
			'rules'=>array(
                '' => 'order/search',
                //REST API
                array('<controller>/get', 'pattern'=>'api/<controller:\w+>', 'verb' => 'GET'),
                array('<controller>/post', 'pattern'=>'api/<controller:\w+>', 'verb' => 'POST'),
                array('<controller>/put', 'pattern'=>'api/<controller:\w+>', 'verb' => 'PUT'),
                array('<controller>/delete', 'pattern'=>'api/<controller:\w+>', 'verb' => 'DELETE'),
//                array('<controller>/<action>', 'pattern'=>'<controller:\w+>/<action:\w+>/<id:.+>', 'verb' => 'GET'),
                array('<controller>/<action>', 'pattern'=>'api/<controller:\w+>/<action:\w+>/<id:.+>', 'verb' => 'GET'),

				/*'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',*/
			),
		),
//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
		// uncomment the following to use a MySQL database
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=autohelp',
            'enableProfiling' => true,
            'enableParamLogging' => true,
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'mysql1234',
            'charset' => 'utf8',
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
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
//				array(
//					'class'=>'CWebLogRoute',
//				),

			),
		),
        'format' => array(
            'class' => 'CFormatter',
            'dateFormat' => 'd.m.Y',
            'booleanFormat'=> array('Нет','Да')
        )
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);