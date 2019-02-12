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


}
