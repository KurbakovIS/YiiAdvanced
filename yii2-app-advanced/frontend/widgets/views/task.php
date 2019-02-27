<?php

use yii\helpers\Url;

?>

<div class="taskConteiner">
    <div class=" card" style="padding: 15px">
        <div class="card-title center">
            <h4>Задание: <?= $model->name ?></h4>
        </div>
        <div class=" card-content">
            <a href="<?= Url::to(['task/one', 'id' => $model->id]) ?>">
                <p><b>Исполниель:</b> <span><?= $model->responsible->username ?></span></p>
                <p><b>Администратор:</b> <span><?= $model->administrator->username ?></span></p>
                <p><b>Описание:</b></p>
                <p><?= $model->description ?></p>
                <p><b>Дата создания:</b></p>
                <p><?= $model->date ?></p>
                <p><b>Делайн:</b></p>
                <?php
                if ($model->dedline_date < date('Y-m-d')):
                    echo " <p style='color: red'> $model->dedline_date </p>";
                elseif ($model->date_complite && $model->date_complite < $model->dedline_date):
                    echo " <p style='color: green'> $model->dedline_date </p>";
                else:
                    echo " <p> $model->dedline_date </p>";
                endif;
                ?>
                <p><b>Дата завершения:</b></p>
                <p><?= $model->date_complite ?></p>
            </a>
        </div>
    </div>
</div>




