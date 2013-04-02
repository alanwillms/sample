<?php
return array(
	'url' => array(
		'defaultController' => 'names',
		'defaultAction' => 'index',
	),
	'dataBase' => array(
		'engine'   => getenv('DB_ENGINE'),
		'host'     => getenv('DB_HOST'),
		'database' => getenv('DB_NAME'),
		'username' => getenv('DB_USER'),
		'password' => getenv('DB_PASSWORD'),
	),
);