<?php

return array(
    // 存储TCP连接信息
    'connection' => array(
        'adapter' => 'Redis',
        'name' => 'cr',
        'pconnect' => true,
        'host' => "dev0926.devel.citypet.cn",
        'port' => 7002,
        'timeout' => 5,
        'prefix' => 'connection'
    )
);
