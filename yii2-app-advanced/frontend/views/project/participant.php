<h1>Добавление участников</h1>
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\tables\Tasks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tasks-form">

    <?php $form = ActiveForm::begin(['action' => Url::to(['project/save', 'id' => $model->id])]); ?>

    <?= $form->field($model, 'id_team')->dropDownList($teamList) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <a class="btn btn-success" href="<?= Url::to(['project/one', 'id' => $model->id]) ?>">Вернуться  в проект</a>
</div>