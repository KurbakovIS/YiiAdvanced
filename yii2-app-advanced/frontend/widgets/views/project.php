<?php
/**
 * Created by PhpStorm.
 * User: Posi_
 * Date: 16.02.2019
 * Time: 21:52
 */

use yii\helpers\Url; ?>

<div class="taskConteiner">
    <a href="<?= Url::to(['project/one', 'id' => $model->id]) ?>">
        <div class=" card">
            <div class="card-title center">
                <h3>Название проекта</h3>
                <h4> <?= $model->name_project ?></h4>
            </div>
            <div class=" card-content">
                <p><b>Описание:</b></p>
                <p><?= $model->description ?></p>
            </div>
        </div>
    </a>
</div>
