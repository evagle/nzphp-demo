<?php

/**
 * By include variables.php, it's able to use variables in config.

    $variables = require_once "variables.php";
    $variables = $variables['variables'];
    return array(
        "cache" => [
            "host" => $variables['host'],
        ]
    );
 */

return array(
    'cache'=>array(
        'locale' => array(
            'adapter' => 'Apc',
            'name' => 'lc',
        ),
        'redis' => array(
            'adapter' => 'Redis',
            'name' => 'nc',
            'pconnect' => true,
            'host' => '127.0.0.1',
            'port' => '7001',
            'timeout' => 5
        ),
    ),

);
