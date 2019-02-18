<?php
/**
 * Created by PhpStorm.
 * User: Posi_
 * Date: 18.02.2019
 * Time: 23:26
 */

namespace common\components;


use common\models\tables\TaskProject;
use common\models\tables\TelegramSubscribe;
use yii\base\Component;
use yii\base\Event;

class BootstrapComponent extends Component
{
    public function init()
    {
        Event::on(TaskProject::class, TaskProject::EVENT_AFTER_INSERT, function (Event $event) {
            $title = $event->sender->name_project;
            $message = "Создан новый проект{$title}";
            $chats = TelegramSubscribe::find()
                ->select('chat_id')
                ->where(['channel'=>TelegramSubscribe::CHANNEL_PROJECT_CREATE])
                ->column();
            foreach ($chats as $chat){
                /** @var \SonkoDmitry\Yii\TelegramBot\Component $bot */
                $bot = \Yii::$app->bot;
                $bot->sendMessage($chat,$message);
            }
        });
    }
}