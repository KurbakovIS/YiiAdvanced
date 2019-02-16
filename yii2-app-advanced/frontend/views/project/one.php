<?php
/**
 * Created by PhpStorm.
 * User: Posi_
 * Date: 16.02.2019
 * Time: 22:23
 */

use \yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\ListView;

?>

    <div style="margin-left: 25px; display: flex;align-items: center;">
        <a class="btn btn-success" style="margin-right: 10px" href="<?= Url::to(['task/create']) ?>">Создать новую
            задачу</a>
        <?php ActiveForm::begin(['method' => 'get']); ?>
        <?= Html::textInput('month') ?>
        <div class="form-group">
            <?= Html::submitButton('Фильтр') ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

<?

echo
ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => function ($model) {
        return \frontend\widgets\TaskWidget::widget([
            'model' => $model
        ]);
    },
    'summary' => false,
    'options' => [
        'class' => 'taskConteiner'
    ]

]);

?>