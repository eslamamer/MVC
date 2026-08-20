<?php

namespace illuminates;
use \illuminates\Router\Rout;

class Start
{
    protected object $router;
    public function run()
    {
        $this->router = new Rout;
        $this->webrout();
        echo $this->router::dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }
    public function webrout(){
            foreach(\App\Core::$globweb as $web){
                new $web;
            }
            include route_path('/web.php');
        }
    public function webapi(){
        foreach(\App\Core::$globapi as $api){
            new $api;
        }
    }
}
