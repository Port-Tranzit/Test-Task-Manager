<?php

use yii\mutex\FileMutex;

return [
    'components' => [
        'mutex' => [
            'class' => FileMutex::class,
            'autoRelease' => true,
        ],
        'db' => require __DIR__ . '/database.php',
    ],

    'params' => require __DIR__ . '/params.php',
];
