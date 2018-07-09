<?php

define('ROOT', dirname(__DIR__));

require '../vendor/autoload.php';

use Framework\Application;

$app = new Application();

$app->run();