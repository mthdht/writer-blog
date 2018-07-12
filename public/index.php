<?php

define('ROOT', dirname(__DIR__));
session_start();

require '../vendor/autoload.php';

use Framework\Application;

$app = new Application();

$app->run();