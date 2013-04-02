<?php
return array(
	'url' => array(
		'defaultController' => 'index',
		'defaultAction' => 'index',
	),
	'dataBase' => array(
		'engine'   => $_ENV['db_engine'],
		'host'     => $_ENV['db_host'],
		'database' => $_ENV['db_name'],
		'username' => $_ENV['db_user'],
		'password' => $_ENV['db_password'],
	),
);