<?php
/**
 * Created by PhpStorm.
 * User: abing
 * Date: 24/11/2016
 * Time: 11:04 AM
 */

use ZPHP\ZPHP;

function includePublicConfigs()
{
    $config = [];
    $publicConfig = array('route.php', 'mail.php');

    foreach ($publicConfig as $file) {
        $file = ZPHP::getRootPath() . DS . 'config' . DS . 'public' . DS . $file;
        $config += include "{$file}";
    }
    return $config;
}