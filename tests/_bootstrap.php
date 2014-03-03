<?php
// This is global bootstrap for autoloading 
require __DIR__ . '/../app/components/AutoLoader.php';
$application = new Application(__DIR__ . '/../app/config/test.php');
