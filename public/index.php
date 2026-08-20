<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    define('ROOT_PATH', dirname(__FILE__));
    require_once __DIR__.'/../vendor/autoload.php';
   (new illuminates\Start)->run();
