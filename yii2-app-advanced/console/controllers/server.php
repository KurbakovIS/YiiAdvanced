<?php

namespace console\controllers;

use console\components\Chat;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;


$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            Chat::class
        )
    ),
    8080
);

$server->run();