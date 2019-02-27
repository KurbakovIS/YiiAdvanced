<?php
/**
 * Created by PhpStorm.
 * User: Posi_
 * Date: 16.02.2019
 * Time: 20:02
 */

use yii\helpers\Url;
use yii\widgets\ListView; ?>


<a href="<?= Url::to(['project/create']) ?>" class="waves-effect waves-light btn" style="margin: 20px">Создать новый проект</a>

<?

echo
ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => function ($model) {
        return \frontend\widgets\ProjectWidget::widget([
            'model' => $model
        ]);
    },
    'summary' => false,
    'options' => [
        'class' => 'taskConteiner'
    ]
]);

?>
