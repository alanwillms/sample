<?php
return array(
	'environment' => getenv('ENVIRONMENT'), // development will turn errors on
	'url' => array(
		'defaultController' => 'people',
		'defaultAction' => 'index',
	),
	'dataBase' => array(
		'engine'   => getenv('DB_ENGINE'),
		'host'     => getenv('DB_HOST'),
		'database' => getenv('DB_NAME'),
		'username' => getenv('DB_USER'),
		'password' => getenv('DB_PASSWORD'),
		'charset'  => 'utf-8',
	),
);