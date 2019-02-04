<h1>Cabinet</h1>

<?
$model = \common\models\tables\Tasks::findOne(1);
\frontend\assets\CalendarAsset::register($this);

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