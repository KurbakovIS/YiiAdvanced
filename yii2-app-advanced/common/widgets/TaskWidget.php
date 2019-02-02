<?php
/**
 * Created by PhpStorm.
 * User: Posi_
 * Date: 31.12.2018
 * Time: 12:06
 */

namespace app\widgets;


use app\models\Tasks;
use yii\base\Widget;

class TaskWidget extends Widget
{
    public $model;

    public function run()
    {
        if (is_a($this->model, Tasks::className())) {
            return $this->render('task', ['model' => $this->model]);
        }
        throw new \Exception('Невозможно отобразить модель');
    }

}