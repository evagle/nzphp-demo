<?php
namespace socket;

use ZPHP\Protocol\Request;
use ZPHP\Core\Route as ZRoute;
use ZPHP\Core\Config as ZConfig;
use common;
use ZPHP\Socket\Callback\SwooleWebSocket;

class WebSocket extends SwooleWebSocket
{
    public function onMessage($server, $frame)
    {
    }

    public function onOpen($server, $request)
    {
    }

    public function onClose()
    {
    }

    public function onReceive()
    {
    }


    public function onWorkerStart($serv, $workId)
    {
    }

    public function onTask($server, $task_id, $from_id, $_data)
    {
    }

    public static function push($server, $fd, $data)
    {
    }

    public function onPacket($server, $data, $addr)
    {
    }

}

