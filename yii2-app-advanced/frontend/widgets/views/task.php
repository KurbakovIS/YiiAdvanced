<?php

use yii\helpers\Url;

?>

<div class="taskConteiner">
    <div class=" card">
        <div class="card-title center">
            <h4>Исполниель: <?= $model->responsible->username ?></h4>
        </div>
        <div class=" card-content">
            <a href="<?= Url::to(['task/one', 'id' => $model->id]) ?>">
                <p> <b>Задание:</b> <span><?= $model->name ?></span></p>
                <p><b>Описание:</b></p>
                <p><?= $model->description ?></p>
                <p><b>Дата создания:</b></p>
                <p><?= $model->date ?></p>
            </a>
        </div>
    </div>
</div>




