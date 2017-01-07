<?php
namespace socket;

use ZPHP\Common\MessagePacker;
use ZPHP\Common\ZLog;
use ZPHP\Core\Route;
use ZPHP\Core\ZConfig;
use ZPHP\Protocol\Request;
use ZPHP\Socket\Callback\SwooleWebSocket;

class WebSocket extends SwooleWebSocket
{
    private static $pack;
    private static $buffer;
    public function onMessage(\swoole_server $server, \swoole_websocket_frame $frame)
    {
        $fd = $frame->id;
        $frameData = $frame->data;
        if(empty($frame->finish)) {
            if(empty(self::$buffer[$fd])) {
                self::$buffer[$fd] = $frameData;
            } else {
                self::$buffer[$fd].= $frameData;
            }
            return ;
        }
        if(!empty(self::$buffer[$fd])) {
            $frameData = self::$buffer[$fd].$frameData;
            unset(self::$buffer[$fd]);
        }

        if(empty($frameData)) return;

        if($frameData == 'p') {
            return;
        }

        $server->push($fd, "hello");

    }

    public function onOpen(\swoole_websocket_server $server, \swoole_http_request $request)
    {
        ZLog::info("websocket", ['onopenstart' ,$request]);
        if (isset(self::$buffer[$request->fd])) {
            unset(self::$buffer[$request->fd]);
        }
        if (empty($request->get['uid'])) {
            ZLog::warning("websocket", ['no param uid']);
            $server->close($request->fd);
        }
        if (empty($request->get['room'])) {
            ZLog::warning("websocket", ['no param room']);
            $server->close($request->fd);
        }
        $userId = $request->get['uid'];
        $room = $request->get['room'];
        $fd = $request->fd;

        $server->bind($fd, intval($userId));

        $connection = self::getConnection();
        $old = $connection->getConnectionByUid($userId);
        ZLog::info("websocket", ['open old', $userId, $old, $connection->getChannelInfo(2)]);
        if (!empty($old)) {
            $oldUid = $connection->getUidByFd($old['fd']);
            if($oldUid == $userId) {
                $data = self::packData([
                    'cmd'=> 'x',
                ]);
                ZLog::info("websocket", "[websocket] user login on other device uid = ".$userId);
                $server->push($old['fd'], $data);
                $connection->deleteConnection($old['fd'], $userId);
                $server->close($old['fd']);
            }
        }
        $connection->addConnection($userId, $fd);

        // 将四个人添加到一个房间
        $connection->addUidToChannel($room, $userId, $fd);

        ZLog::info("websocket", "[websocket] Add connection [uid,fd] = [".$userId.", ".$fd."]");
        ZLog::info("websocket", [$room, $connection->getChannelInfo($room), $connection->getConnectionByUid($userId), $connection->getUidByFd($fd)]);

    }

    public function onClose(\swoole_server $server, $fd,  $from_id)
    {
        parent::onClose($server, $fd, $from_id);
        $connection = self::getConnection();
        $uid = $connection->getUidByFd($fd);
        ZLog::info("websocket", ["[websocket] User logout uid = ".$uid . "  $fd"]);
        ZLog::info("websocket", ["close uid", $connection->getConnectionByUid($uid)]);
        ZLog::info("websocket", ["close room", $connection->getChannelInfo(2)]);
        $connection->deleteConnection($fd, $uid);
        ZLog::info("websocket", ["close uid", $connection->getConnectionByUid($uid)]);
        ZLog::info("websocket", ["close room", $connection->getChannelInfo(2)]);

    }

    public function onWorkerStart(\swoole_server $server, $workId)
    {
        opcache_reset();
        parent::onWorkerStart($server, $workId);
        \register_shutdown_function(function() use ($server) {
            $params = Request::getParams();
            Request::setViewMode(ZConfig::getField('project', 'view_mode', 'Json'));
            ZLog::info('websocket', ['shutdown', $params]);
        });
    }

    public function onTask(\swoole_server $server, $task_id, $from_id, $_data)
    {
        if(is_string($_data)) {
            $_data = json_decode($_data, true);
        }
        switch ($_data[0]) {
            case 1:               //单发
                self::push($server, $_data[1][0], self::packData($_data[1][1]));
                ZLog::info("websocket", [$_data[1][1], $_data[1][0]]);
                break;
            case 2:                 //组播
                $connection = \ZPHP\Conn\Factory::getInstance();
                $channelName = $_data[1][0];
                $channel = $connection->getChannelInfo($channelName);
                ZLog::info("websocket", [$_data[1][1], $channel]);
                $data = self::packData($_data[1][1]);
                foreach($channel as $uid => $_fd) {
                    if (!self::push($server, $_fd, $data)) {
                        $connection->deleteUidFromChannel($channelName, $uid);
                        ZLog::info("websocket", ["[websocket] Delete user from channel [channel, uid] = [$channelName, $uid]"]);
                    }
                }
                break;
            case 3:             //按需求广播
                $data = $_data[1];
                foreach ($data['params'] as $items) {
                    if(empty($data['channel'][$items[1]])) {
                        continue;
                    }
                    $sendData = self::packData($items[0]);
                    foreach($data['channel'][$items[1]] as $_uid=>$_fd) {
                        self::push($server, $_fd, $sendData);
                    }
                }
                break;
        }
    }

    public function onPacket(\swoole_server $server, $data, $clientInfo)
    {
        $server->task($data);
    }

    public static function push(\swoole_server $server, $fd, $data, $channel = false)
    {
        $status = $server->push($fd, $data);
        if (!$status) {
            $info = $server->connection_info($fd);
            if (!$info) {
                $connection = self::getConnection();
                $uid = $connection->getUidByFd($fd);
                $connection->deleteConnection($fd, $uid);
                ZLog::info("websocket", ["[websocket] Delete connection [uid, fd] = [$uid, $fd]"]);
            }
            return false;
        }
        return true;
    }

    public static function getConnection()
    {
        $config = ZConfig::get('connection');
        return \ZPHP\Conn\Factory::getInstance($config['adapter'], $config);
    }

    public static function packData($result) {
        if(empty(self::$pack)) {
            self::$pack = new MessagePacker();
        }
        if(is_array($result)) {
            $jsonData = json_encode($result);
        } else {
            $jsonData = $result;
        }
        $data = gzencode($jsonData);
        $len = strlen($data);
        self::$pack->resetForPack();
        self::$pack->writeInt($len+12);
        self::$pack->writeInt($result['cmd']);
        self::$pack->writeString($data, $len);
        return self::$pack->getData();

    }


}

