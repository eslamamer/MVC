<?php

namespace illuminates;

use illuminates\Router\Router;
use App\Http\Controllers\HomeController;

class Start
{
    protected object $router;
    public function run()
    {
        $this->router = new Router();
        $this->router->add("GET", "/", HomeController::class, 'index');
        $this->router->add("GET", "about", HomeController::class, 'about');
    }

    public function __destruct()
    {
        $this->router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }
}
