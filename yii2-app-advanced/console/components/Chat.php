<?php

namespace console\components;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Yii;

class Chat implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        echo "server started \n";

        $this->clients = new \SplObjectStorage();

    }

    function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "New connection : {$conn->resourceId}\n";
    }

    function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "user : {$conn->resourceId} disconect\n";
    }


    function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "\n conn : {$conn->resourceId}closed with error\n";

        $conn->close();
        $this->client->detach($conn);
    }

    function onMessage(ConnectionInterface $from, $msg)
    {
        echo "{$from->resourceId}: {$msg}\n";

        $data = json_decode($msg, true);
        if (is_null($data)) {
            echo "invalid data\n";
            return $from->close();
        }
        echo $from->resourceId;
        $model = new \common\models\tables\Chat();
        echo "{$model}";
        foreach ($this->clients as $client) {
            $client->send($msg);
        }
    }
}