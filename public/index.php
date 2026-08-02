<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    //include composer autoload
    require_once __DIR__.'/../vendor/autoload.php';
    use illuminates\Router\Router;
    $router = new Router();
    $router->add("GET", "/home", "HomeController", "index");
    var_dump($router->routes());