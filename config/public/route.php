<?php
    return array(
        'route'=>array(
            'static' => array(
                '/api/login' => array(
                    'main\\main',
                    'login'
                ),
            ),
            'dynamic' => array(                             //动态路由
                '/^\/api\/(.*?)\/(.*?)$/iU' => array(       //匹配 http://host/api/ctrl/method
                    'api\\{1}',                             //ctrl类
                    '{2}',                                  //具体执行的方法
                    array(),                                //对应的参数名
                    ''                                      //反向返回的格式, 通过内置的
                ),
                '/^\/main\/(.*?)\/(.*?)$/iU' => array(       //匹配 http://host/api/ctrl/method
                    'main\\{1}',                             //ctrl类
                    '{2}',                                  //具体执行的方法
                    array(),                                //对应的参数名
                    ''                                      //反向返回的格式, 通过内置的
                ),

            ),
            'cache'=>false,                                  //开启cache(会把pathinfo缓存在locale cache中)
        ),
    );
