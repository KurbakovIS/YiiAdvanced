<?php
/**
 * Created by PhpStorm.
 * User: Posi_
 * Date: 18.02.2019
 * Time: 23:54
 */

namespace frontend\controllers;


use common\models\tables\Tasks;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

class ApitaskController extends ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authentificator'] = [
            'class' => HttpBearerAuth::class,
            'auth' => function ($token) {
                $user = User::findIdentityByAccessToken($token);
                if ($user !== null) {
                    return $user;
                }
                return null;
            }
        ];
        return $behaviors;
    }


    public $modelClass = Tasks::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex()
    {
        $filter = \Yii::$app->request->get('filter');
        $query = Tasks::find();
        if ($filter) {
            $query->filterWhere($filter);
        }


        return new ActiveDataProvider([
            'query' => $query
        ]);
    }
}