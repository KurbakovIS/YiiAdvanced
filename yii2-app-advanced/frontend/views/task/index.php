<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

//\app\assets\CalendarAsset::register($this);
?>
<div style="margin-left: 25px; display: flex;align-items: center; justify-content: space-between;align-items: start">
    <a class="btn btn-success" style="margin-top: 20px" href="<?= Url::to(['task/create']) ?>">Создать новую
        задачу</a>
    <div>
        <h3>Фильтры</h3>
        <?php ActiveForm::begin(['method' => 'get']); ?>
        <?= Html::textInput('month') ?>
        <div class="form-group">
            <?= Html::submitButton('Фильтр') ?>
        </div>
        <?php ActiveForm::end(); ?>
        <?php ActiveForm::begin(['method' => 'get']); ?>
        <div style="display: flex;flex-direction: column">
            <label>
                <input name="filter" type="radio" value="deadline"/>
                <span>Показать просроченные задачи</span>
            </label>
            <label>
                <input name="filter" type="radio" value="last7day"/>
                <span>Закрытые задачи за последнюю неделю</span>
            </label>
            <label>
                <input name="filter" type="radio" value="clean"/>
                <span>Очистить фильтр</span>
            </label>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Фильтр') ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>


</div>
<?

echo
\yii\widgets\ListView::widget([
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


