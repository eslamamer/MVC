<?php

namespace illuminates;
use \illuminates\Router\Rout;

class Start
{
    
    public function run()
    {
        echo Rout::dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }
    public function webrout(){
            foreach(\App\Core::$globweb as $web){
                new $web;
            }
            include route_path('/web.php');
        }
    public function webapi(){
        foreach(\app\Core::$globapi as $api){
            new $api;
        }
    }
}
