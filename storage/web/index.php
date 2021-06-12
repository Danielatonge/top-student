<?php
ini_set('max_input_vars', '99999');
error_reporting(0);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET,DELETE,HEAD,OPTIONS,POST,PUT');
header('Access-Control-Allow-Headers: *');
// Composer
require(__DIR__ . '/../../vendor/autoload.php');

// Environment
require(__DIR__ . '/../../common/env.php');

// Yii
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');

// Bootstrap
require(__DIR__ . '/../../common/config/bootstrap.php');

// App Config
$config = require(__DIR__ . '/../config/base.php');

(new yii\web\Application($config))->run();
