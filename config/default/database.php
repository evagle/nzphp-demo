<?php
/**
 * By include variables.php, it's able to use variables in config.

    $variables = require_once "variables.php";
    $variables = $variables['variables'];
    return array(
        "mysql" => [
            "host" => $variables['host'],
        ]
    );
 */
return array(

	/*
	|--------------------------------------------------------------------------
	| Database Connections
	|--------------------------------------------------------------------------
	|
	| Here are each of the database connections setup for your application.
	| Of course, examples of configuring each database platform that is
	| supported by Laravel is shown below to make development simple.
	|
	|
	| All database work in Laravel is done through the PHP PDO facilities
	| so make sure you have the driver for your particular database of
	| choice installed on your machine before you begin development.
	|
	*/
    'pdo' => array(
        'accounts' => array(
            'driver' => 'mysql',
            'host' => '120.26.71.45',
            'port' => 3310,
            'database' => 'pocketpet_dev0926_user',
            'username' => 'pocketpet',
            'password' => '3MjdvUuXqxca6cbc',
            'charset' => 'UTF8',
            'collation' => 'utf8_unicode_ci',
            'ping' => 1,
            'pingtime' => 7200,
            'prefix'    => '',
            'strict'    => false,
            'options'   => array(
                PDO::ATTR_PERSISTENT => false,
            ),
        ),
    ),
    'mongodb' => array(
        'pois'=>array(
            array(
                'name' => 'mongo-01',
                'dsn' => 'mongodb://127.0.0.1:27017',
                'host' => '127.0.0.1',
                'port' => 27017,
                'dbName'=>'POI',
                'option'=> array(
                    'connect'=>TRUE,
                ),
                'distance'=> 250,  //范围(m)
                'weight' => 1,
            ),
        )
    ),
    'redis' => array(
        'redisdemo' => array(
            'adapter' => 'RL',
            'servers' => [
                [
                    '_prefix' => 'prefix0',
                    'name' => 'redisdemo',
                    'pconnect' => true,
                    'host' =>  '127.0.0.1',
                    'port' => 17001,
                    'timeout' => 5,
                    'weight' => 1,
                ]
            ]
        ),
    ),

);
