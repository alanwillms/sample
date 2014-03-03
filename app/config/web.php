<?php
return array(
	// You did not need to use "$_ENV" if you do not want...
	'environment' => getenv('SAMPLE_ENVIRONMENT'), // development will turn errors on
	'url' => array(
		'defaultController' => 'people',
		'defaultAction' => 'index',
	),
	'dataBase' => array(
		'engine'   => getenv('SAMPLE_DB_ENGINE'),
		'host'     => getenv('SAMPLE_DB_HOST'),
		'database' => getenv('SAMPLE_DB_NAME'),
		'username' => getenv('SAMPLE_DB_USER'),
		'password' => getenv('SAMPLE_DB_PASSWORD'),
		'charset'  => 'utf-8',
	),
);