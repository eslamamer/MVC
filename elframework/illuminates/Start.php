<?php

namespace illuminates;

use illuminates\Router\Router;
use App\Http\Controllers\HomeController;

class Start
{
    public function run()
    {
        $router = new Router();
        $router->add("GET", "/", HomeController::class, 'index');
        $router->add("GET", "about", HomeController::class, 'about');
        $router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }
}
