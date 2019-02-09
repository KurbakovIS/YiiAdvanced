<?php


namespace app;


use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class Chat implements MessageComponentInterface
{

    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage();
        echo "server started \n";
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

        foreach ($this->clients as $client) {
            $client->send($msg);
        }
    }
}