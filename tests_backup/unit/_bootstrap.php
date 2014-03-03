<?php
require_once 'app/components/AutoLoader.php';

ActiveRecord::setDb($this->getModule('Db')->driver->getDbh());