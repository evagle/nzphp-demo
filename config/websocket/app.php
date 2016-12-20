<?php
use ZPHP\ZPHP;

define('KEY_SEPARATOR', '.');
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', ZPHP::getRootPath());
}
define('SERVER_ID', 1);

$config = array(
    'server_mode' => 'Socket',
    'is_long_service' => 1,               //是否常驻服务
    'pipe' => 1,               //是否开启pipe
    'project_name' => 'websocket_demo',
    'app_path' => 'app',
    'ctrl_path' => 'controllers',
    'project' => array(
        'view_mode' => 'Json',
        'serialize_type' => 'Msgpack',
        'exception_handler' => 'common\AppException::exceptionHandler',
        'debug_mode' => true,
        'status_waring' => 1,
        'status_error' => 2,
    ),
    'socket' => array(
        'host' => '0.0.0.0', //socket 监听ip
        'port' => 9901, //socket 监听端口
        'adapter' => 'Swoole', //socket 驱动模块
        'server_type' => \ZPHP\Socket\Adapter\Swoole::TYPE_WEBSOCKET,
        'daemonize' => 1, //是否开启守护进程
        'debug_mode' => true,
        'work_mode' => 3,                       // 1:base, 2: 多线程 3: 多进程，Doc：http://wiki.swoole.com/wiki/page/353.html
        'worker_num' => 2,
        'task_worker_num' => 2,
        'max_request' => 0,                     // 单个进程最大处理请求数
        'addlisten' => array(                   // 额外监听端口10901，业务逻辑通过UDP来发送消息给websocket server, server收到后push给客户端
            'ip' => '0.0.0.0',
            'port' => 10901
        ),
        'client_class' => 'socket\\WebSocket',  // socket 回调类

        'protocol' => 'Json',                   // socket通信数据协议
        'dispatch_mode' => 5,                   // 1，轮循模式 2，固定模式 3，抢占模式 4，IP分配 5，UID分配 Doc: http://wiki.swoole.com/wiki/page/277.html
        'heartbeat_idle_time' => 60,
        'heartbeat_check_interval' => 5,
        'group' => 'www-data',
        'user' => 'www-data',

        'open_length_check' => true,
        'package_length_type' => 'N',
        'package_length_offset' => 0,       //第N个字节是包长度的值
        'package_body_offset' => 4,       //第几个字节开始计算长度
        'package_max_length' => 2000000,  //协议最大长度
        // task进程使用消息队列,task_ipc_mode => 1 | 2 | 3，默认为1就是普通的unix socket通信方式(最大缓冲8M)，2, 3就是使用消息队列模式（内存无限制）。模式2和模式3的不同之处是，模式2支持定向投递，$serv->task($data, $task_worker_id) 这里可以指定投递到哪个task进程。模式3是完全争抢模式，task进程会争抢队列，将无法使用定向投递，即使指定了$task_worker_id，在模式3下也是无效的。
        'task_ipc_mode' => 1,
        'message_queue_key' => 0x72000100, // 指定一个消息队列key。如果需要运行多个swoole_server的实例，务必指定。否则会发生数据错乱
        'pipe_buffer_size' => 128 * 1024 * 1024, //缓冲区 必须为数字
    ),
);

if (file_exists('includes.config.php')) {
    require('includes.config.php');
    $includeContents = includePublicConfigs();
    $config += $includeContents;
}

return $config;