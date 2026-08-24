<?php

namespace illuminates;
use \illuminates\Router\Rout;
use \illuminates\Router\Segment;

class Start
{
    protected object $router;
    public function run()
    {
        $this->router = new Rout;
        if(Segment::get(0) == "api"){
            $this->apiٌRout();
        }else{
            $this->webrout();
        }
        echo $this->router::dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }
    public function webrout(){
        foreach(\App\Core::$globweb as $web){
            new $web;
        }
        include route_path('/web.php');
        }
    public function apiٌRout(){
        foreach(\App\Core::$globapi as $api){
            new $api;
        }
        include route_path('/api.php');
    }
}
