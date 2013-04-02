<?php

require 'app/components/AutoLoader.php';

$application = new Application('app/config.php');

$application->run();