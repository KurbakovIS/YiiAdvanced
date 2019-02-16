<?php
/**
 * Created by PhpStorm.
 * User: Posi_
 * Date: 16.02.2019
 * Time: 17:39
 */

namespace console\controllers;


use common\models\tables\TaskProject;
use common\models\tables\Tasks;
use common\models\tables\TelegramOffset;
use common\models\tables\TelegramSubscribe;
use common\models\tables\Users;
use SonkoDmitry\Yii\TelegramBot\Component;
use TelegramBot\Api\Types\Message;
use TelegramBot\Api\Types\Update;
use yii\console\Controller;

class TelegramController extends Controller
{
    /** @var Component */
    private $bot;
    private $offset = 0;

    public function init()
    {
        parent::init();
        $this->bot = \Yii::$app->bot;
    }

    public function actionIndex()
    {
        $updates = $this->bot->getUpdates($this->getOffset() + 1);
        $updCount = count($updates);
        if ($updCount > 0) {
            foreach ($updates as $update) {
                $this->updateOffset($update);
                $this->processCommand($update->getMessage());
            }
            echo "Новых сообщений " . $updCount . PHP_EOL;
        } else {
            echo "Новых нет";
        }
    }

    private function getOffset()
    {
        $max = TelegramOffset::find()
            ->select('id')
            ->max('id');
        if ($max > 0) {
            $this->offset = $max;
        }
        return $this->offset;
    }

    private function updateOffset(Update $update)
    {
        $model = new TelegramOffset([
            'id' => $update->getUpdateId(),
            'timestamp_offset' => date('Y-m-d H:i:s')
        ]);
        $model->save();
    }

    private function processCommand(Message $message)
    {
        $params = explode(" ", $message->getText());
        $command = $params[0];
        $response = " ";
        switch ($command) {
            case '/help':
                $response .= "Доступные команды \n";
                $response .= "/help - список комманд \n";
                $response .= "/project_create ##project_name## ##project_description## ##author_name## - создание проекта\n";
                $response .= "/task_create ##task_name## ##responsible## ##project## - создание таска \n";
                $response .= "/sp_create - подписка на создание проекта \n";
                break;
            case "/sp_create":
                $model = new TelegramSubscribe([
                    'chat_id' => $message->getFrom()->getId(),
                    'channel' => TelegramSubscribe::CHANNEL_PROJECT_CREATE
                ]);
                if ($model->save()) {
                    $response = 'Вы подписаны на оповещения об создании проектов';
                } else {
                    $response = 'Error';
                }
                break;
            case "/project_create":
                $model = new TaskProject([
                    'name_project' => $params[1],
                    'description' => $params[2],
                    'name_author' => $params[3]

                ]);
                if ($model->save()) {
                    $response = 'Вы создали проект с названием ' . $params[1];
                } else {
                    $response = 'Error';
                }
                break;
            case "/task_create":
                $model = new Tasks([
                    'name' => $params[1],
                    'responsible_id' => $params[2],
                    'id_project' =>$params[3]

                ]);
                if ($model->save()) {
                    $response = "Вы создали задачу с названием  $params[1], в задаче $params[3] ";
                } else {
                    $response = 'Error';
                }
                break;
        }

        $this->bot->sendMessage($message->getFrom()->getId(), $response);
    }
}