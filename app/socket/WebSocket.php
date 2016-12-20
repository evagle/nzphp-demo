<?php
namespace socket;

use ZPHP\Protocol\Request;
use ZPHP\Core\Route as ZRoute;
use ZPHP\Core\Config as ZConfig;
use common;
use ZPHP\Socket\Callback\SwooleWebSocket;

class WebSocket extends SwooleWebSocket
{
    public function onMessage(\swoole_server $server, \swoole_websocket_frame $frame)
    {
    }

    public function onOpen($server, $request)
    {
    }

    public function onClose(\swoole_server $server, int $fd, int $from_id)
    {
    }

    public function onReceive(\swoole_server $server, int $fd, int $from_id, string $data)
    {
    }


    public function onWorkerStart($server, $workId)
    {
    }

    public function onTask($server, $task_id, $from_id, $_data)
    {
    }

    public static function push($server, $fd, $data)
    {
    }

    public function onPacket($server, $data, $clientInfo)
    {
    }

}

