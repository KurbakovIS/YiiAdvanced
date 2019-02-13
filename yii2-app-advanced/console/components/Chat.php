<?php

namespace console\components;

use common\models\tables\Tasks;
use common\models\tables\Users;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use common\models\tables\Chat as MyChat;

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
//            $allMessage = MyChat::find()->where(['<','timeMessage','2019-02-13 01:00:43'])->all();
//            var_dump($allMessage->message);
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
        $userlogin = Users::findOne($data['id_User']);
        try {
            (new MyChat($data))->save();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
        foreach ($this->clients[$id_Task] as $client) {
            $client->send($userlogin->username . ': ' . $data['message']);
        }
    }
}