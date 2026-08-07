<?php

namespace illuminates;
use \illuminates\Router\Rout;

class Start
{
    protected object $router;
    
    public function run()
    {
        include base_path("Routes/web.php");
        config("router.path");
        Rout::dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }

    public function __destruct(){}
}
