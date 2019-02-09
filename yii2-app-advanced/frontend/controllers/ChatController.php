<?php

namespace frontend\controllers;

use common\models\tables\Chat;
use Yii;

class ChatController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionAddMessage()
    {
        $model = new Chat();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        } else {
            Yii::$app->session->setFlash('error', 'Не удалось отправить сообщение');
        }
        $this->redirect(Yii::$app->request->referrer);
    }

}
