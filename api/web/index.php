<?php

use yii\base\InvalidConfigException;

ini_set("date.timezone",'Europe/Moscow');
ini_set('post_max_size', '20M');
ini_set('upload_max_filesize', '20M');

require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

define('YII_ENV', $_ENV['APP_ENV'] ?: 'prod');
define('YII_DEBUG', $_ENV['APP_ENV'] !== 'prod');

require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';

$config = array_merge_recursive(
    require __DIR__ . '/../../api/config/web.php',
    require __DIR__ . '/../../config/app.php'
);

try {
    $app = new yii\web\Application($config);
    $app->run();
} catch (InvalidConfigException $e) {
    echo $e->getMessage() . PHP_EOL;
}
