<?php
/**
 * Created by PhpStorm.
 * User: Posi_
 * Date: 15.02.2019
 * Time: 23:35
 */

namespace frontend\controllers;

use SonkoDmitry\Yii\TelegramBot\Component;
use yii\web\Controller;

class TelegramController extends Controller
{
    public function actionRecieve()
    {
        /** @var Component $bot */
        $bot = \Yii::$app->bot;

        $updates = $bot->getUpdates();

        $messages = [];

        foreach ($updates as $update) {
            $message = $update->getMessage();
            $username = $message->getFrom()->getUsername();
            $messages[] = [
                'text' => $message->getText(),
                'username' => $username
            ];
        }
        return $this->render('receive', ['message' => $message]);
    }

    public  function actionSend(){
        /** @var Component $bot */
        $bot = \Yii::$app->bot;
        $bot->sendMessage(492292269,'Hi');
    }
}