<?php

use api\components\ApiUserProvider;
use App\Interfaces\IUserProvider;
use App\Models\User;
use yii\web\Application;

return [
    'id' => 'test-task',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',

    'aliases' => [
        '@root' => realpath(__DIR__ . '/../'),
        '@api' => realpath(__DIR__ . '/../../api'),
        '@app' => realpath(__DIR__ . '/../../app'),

        '@vendor' => realpath(__DIR__ . '/../../vendor'),
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],

    'bootstrap' => [
        function () {
            Yii::$container->set(IUserProvider::class, ApiUserProvider::class);
        },
    ],

    'components' => [
        'request' => [
            'baseUrl' => '',
            'enableCsrfValidation' => false,
            'cookieValidationKey' => $_ENV['APP_KEY'],
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'multipart/form-data' => 'yii\web\MultipartFormDataParser',
            ],
        ],
        'user' => [
            'identityClass' => User::class,
            'enableSession' => false,
            'loginUrl' => null,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'OPTIONS <controller>/<action>' => 'root/options',
            ],
        ],
    ],
];
