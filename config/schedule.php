<?php

use omnilight\scheduling\Schedule;

/**
 * @var Schedule $schedule
 */

$phpPath = $_ENV['PHP_PATH'] ?? 'php';
$yiiPath = Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'yii';

$schedule->exec("{$phpPath} {$yiiPath} task/update")->everyMinute();
