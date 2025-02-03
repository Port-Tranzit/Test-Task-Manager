<?php

use omnilight\scheduling\Schedule;
use omnilight\scheduling\ScheduleController;

return [
    'id' => 'test-task-cli',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'App\Commands',

    'controllerMap' => [
        'schedule' => ScheduleController::class,
    ],

    'components' => [
        'schedule' => Schedule::class,
    ],
];
