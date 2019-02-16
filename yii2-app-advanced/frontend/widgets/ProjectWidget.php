<?php
/**
 * Created by PhpStorm.
 * User: Posi_
 * Date: 16.02.2019
 * Time: 20:04
 */

namespace frontend\widgets;


use common\models\tables\TaskProject;
use yii\base\Widget;

class ProjectWidget extends Widget
{
    public $model;

    public function run()
    {
        if (is_a($this->model, TaskProject::class)) {
            return $this->render('project', ['model' => $this->model]);
        }
        throw new \Exception('Невозможно отобразить модель');
    }
}