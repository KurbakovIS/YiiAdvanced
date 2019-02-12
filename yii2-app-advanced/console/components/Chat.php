<?php

namespace console\components;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use common\models\tables\Chat as MyChat;
use Yii;

class Chat implements MessageComponentInterface
{
    protected $clients = [];

    public function __construct()
    {
        echo "server started \n";
    }

    function onOpen(ConnectionInterface $conn)
    {
        $queryString = $conn->httpRequest->getUri()->getQuery();
        $id_Task = explode("=", $queryString)[1];
        try {
            $this->clients[$id_Task][$conn->resourceId] = $conn;
//            var_dump($conn->resourceId);
        } catch (\Exception $e) {
            $e->getMessage();
        }

        echo "New connection : {$conn->resourceId}\n";
    }

    function onClose(ConnectionInterface $conn)
    {
        echo "user : {$conn->resourceId} disconect!\n";
    }


    function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "\n conn : {$conn->resourceId}closed with error\n";

        $conn->close();
    }

    function onMessage(ConnectionInterface $from, $msg)
    {
        echo "$msg\n";

        $data = json_decode($msg, true);
        $id_Task = $data['id_Task'];
        try {
            (new MyChat($data))->save();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
//        var_dump($this->clients[$id_Task]);
        foreach ($this->clients[$id_Task] as $client) {
            $client->send($data['message']);
        }
    }
}