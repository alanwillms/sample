<?php

require 'app/components/AutoLoader.php';

$application = new Application('app/config/web.php');

$application->run();