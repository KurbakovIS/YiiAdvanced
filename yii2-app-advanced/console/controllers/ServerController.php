<?php
/**
 * Created by PhpStorm.
 * User: Posi_
 * Date: 09.02.2019
 * Time: 22:36
 */

namespace console\controllers;


use console\components\Chat;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use yii\console\Controller;

class ServerController extends Controller
{
    public function actionStartSocket($port = 8080)
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat()
                )
            ),
            $port
        );
        $server->run();
    }
}