<?php
/**
 * Created by PhpStorm.
 * User: abing
 * Date: 24/11/2016
 * Time: 11:04 AM
 */

$publicConfig = [];
$publicConfigFiles = array('route.php', 'mail.php');

foreach ($publicConfigFiles as $file) {
    $file = dirname(__DIR__) . DS . 'public' . DS . $file;
    \ZPHP\Common\ZLog::info('config', [$file]);
    $publicConfig += include "{$file}";
}

return $publicConfig;