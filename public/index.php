<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    //include composer autoload
    require_once __DIR__.'/../vendor/autoload.php';
    use illuminates\Router\Router;
    use App\Http\Controllers\HomeController;
    $router = new Router();
    $router->add("GET", "/"    , HomeController::class, 'index');
    $router->add("GET", "about", HomeController::class, 'about');

   echo $router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
