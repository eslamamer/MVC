<?php

namespace illuminates;

use \illuminates\Router\Rout;
use App\Http\Controllers\HomeController;

class Start
{
    protected object $router;
    
    public function run()
    {
        $this->router = new Rout();
        $this->router->add("GET", "/", HomeController::class, 'index');
        $this->router->add("GET", "about", HomeController::class, 'about');
        $this->router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }

    public function __destruct(){}
}
