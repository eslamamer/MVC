<?php

namespace illuminates;
use \illuminates\Router\Rout;

class Start
{
    protected object $router;
    
    public function run()
    {
        include route_path('/web.php');
        Rout::dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }
}
