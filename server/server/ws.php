<?php

use Swoole\WebSocket\Frame;

$server = new Swoole\WebSocket\Server("0.0.0.0", 9501);

$server->on('message', function (Swoole\WebSocket\Server $server, Frame $frame) {
    foreach ($server->connections as $fd) {
        if ($fd !== $frame->fd && $server->isEstablished($fd)) {
            $server->push($fd, $frame->data);
        }
    }
});

$server->start();