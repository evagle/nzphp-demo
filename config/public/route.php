<?php
    return array(
        'route'=>array(
            'static' => array(
                '/api/config/sync' => array(
                    'config\\main',
                    'sync',
                ),
                '/api/config/get' => array(
                    'config\\main',
                    'get',
                ),
                '/admin' => array(
                    'admin\\login',
                    'main'
                ),
                '/api/login' => array(
                    'main\\main',
                    'login'
                ),
                '/api/anySDKLogin' => array(
                    'login\\main',
                    'anySDKLogin'
                ),
                '/api/serverlist' => array(
                    'main\\main',
                    'serverlist'
                ),
                '/api/setServerId' => array(
                    'main\\main',
                    'setServerId'
                ),
                '/api/osstoken' => array(
                    'main\\main',
                    'osstoken'
                ),
                '/api/debugFight' =>[
                    'test\\main',
                    'debugFight'
                ],
                '/api/randomname' => [
                    'api\\user',
                    'random'
                ],
                '/api/notify' => [
                    'main\\main',
                    'notify'
                ],
                '/api/updateresource' => [
                    'main\\main',
                    'resource'
                ],
                '/api/saveAppLog' => [
                    'main\\main',
                    'saveAppLog'
                ],
                '/api/saveNewUserLog' => [
                    'main\\main',
                    'saveNewUserLog'
                ],

            ),
            'dynamic' => array(                             //动态路由
                '/^\/api\/(.*?)\/(.*?)$/iU' => array(       //匹配 http://host/api/ctrl/method
                    'api\\{1}',                             //ctrl类
                    '{2}',                                  //具体执行的方法
                    array(),                                //对应的参数名
                    ''                                      //反向返回的格式, 通过内置的
                ),
                '/^\/api\/config\/get\/(.*?)$/iU' => array(       //匹配 http://host/config/method
                    'config\\main',                             //ctrl类
                    'get',                                  //具体执行的方法
                    array("files"),                                //对应的参数名
                    ''                                      //反向返回的格式, 通过内置的
                ),

                '/^\/config\/(.*?)$/iU' => array(       //匹配 http://host/config/method
                    'config\\main',                             //ctrl类
                    '{1}',                                  //具体执行的方法
                    array(),                                //对应的参数名
                    ''                                      //反向返回的格式, 通过内置的
                ),
                '/^\/tool\/(.*?)\/(.*?)$/iU' => array(       //匹配 http://host/tool/ctrl/method
                    'tool\\{1}',                             //ctrl类
                    '{2}',                                   //具体执行的方法
                    array(),                                 //对应的参数名
                    ''                                       //反向返回的格式, 通过内置的
                ),

                '/^\/test\/(.*?)$/iU' => array(       //匹配 http://host/test/method
                    'test\\main',                             //ctrl类
                    '{1}',                                  //具体执行的方法
                    array(),                                //对应的参数名
                    ''                                      //反向返回的格式, 通过内置的
                ),

                '/^\/admin\/(.*?)\/(.*?)$/iU' => array(       //匹配 http://host/api/ctrl/method
                    'admin\\{1}',                             //ctrl类
                    '{2}',                                  //具体执行的方法
                    array(),                                //对应的参数名
                    ''                                      //反向返回的格式, 通过内置的
                ),
                '/^\/dashboard\/(.*?)\/(.*?)$/iU' => array(       //匹配 http://host/api/ctrl/method
                    'dashboard\\{1}',                             //ctrl类
                    '{2}',                                  //具体执行的方法
                    array(),                                //对应的参数名
                    ''                                      //反向返回的格式, 通过内置的
                ),
                '/^\/static\/icon\/(.*?)$/iU' => array(       //匹配 http://host/test/method
                    'config\\main',                             //ctrl类
                    'icon',                                  //具体执行的方法
                    array(),                                //对应的参数名
                    ''                                      //反向返回的格式, 通过内置的
                ),
                '/^\/main\/(.*?)\/(.*?)$/iU' => array(       //匹配 http://host/main/crtl/method
                    'main\\{1}',                             //ctrl类
                    '{2}',                                  //具体执行的方法
                    array(),                                //对应的参数名
                    ''                                      //反向返回的格式, 通过内置的
                ),
                '/^\/login\/(.*?)\/(.*?)$/iU' => array(       //匹配 http://host/login/ctrl/method
                    'login\\{1}',                             //ctrl类
                    '{2}',                                   //具体执行的方法
                    array(),                                 //对应的参数名
                    ''                                       //反向返回的格式, 通过内置的
                ),
            ),
            'cache'=>false,                                  //开启cache(会把pathinfo缓存在locale cache中)
        ),
    );
