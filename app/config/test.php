<?php
return array(
    'environment' => 'test',
    'url' => array(
        'defaultController' => 'people',
        'defaultAction' => 'index',
    ),
    'dataBase' => array(
        'engine'   => getenv('SAMPLE_TEST_DB_ENGINE'),
        'host'     => getenv('SAMPLE_TEST_DB_HOST'),
        'database' => getenv('SAMPLE_TEST_DB_NAME'),
        'username' => getenv('SAMPLE_TEST_DB_USER'),
        'password' => getenv('SAMPLE_TEST_DB_PASSWORD'),
        'charset'  => 'utf-8',
    ),
);