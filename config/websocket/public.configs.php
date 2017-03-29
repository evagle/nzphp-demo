<?php
/**
 * Created by PhpStorm.
 * User: abing
 * Date: 24/11/2016
 * Time: 11:04 AM
 */

use ZPHP\ZPHP;

/*****
 * 加载public config，框架会最先加载这里的配置，再加载项目配置，
 * 如果项目配置中出现相同的key，将会覆盖这里的配置
 * @return array|mixed
 */
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