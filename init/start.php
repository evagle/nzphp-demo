<?php

use ZPHP\ZPHP;

$rootPath = dirname(__DIR__);
require_once __DIR__ . "/autoload.php";
require_once $rootPath . "/config/ConfigRoute.php";

$config = ConfigRoute::getConfigPath();

ZPHP::run($rootPath, true, $config);

