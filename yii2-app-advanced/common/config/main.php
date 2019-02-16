<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'bot' => [
            'class' => \SonkoDmitry\Yii\TelegramBot\Component::class,
            'apiToken' => '616198847:AAEBrO9XxlNv1iuM3FoAEPhwd7J4bAKf4Zc'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
