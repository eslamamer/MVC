<?php

namespace illuminates;
use \illuminates\Router\Rout;
use \illuminates\Router\Segment;
use \illuminates\views\Settings;

class Start
{
    protected object $router;
    public function run()
    {
        $this->router = new Rout;
        Settings::setTimeZone();
        $reqType = Segment::get(0);
        if($reqType == "api"){
            $this->apiٌRout();
        }else{
            $reqType = "web";
            $this->webrout();
        }
        echo $this->router::dispatch(parse_url($_SERVER['REQUEST_URI'])['path'], $_SERVER['REQUEST_METHOD'], $reqType);
    }
    public function webrout(){
        foreach(\App\Core::$globweb as $web){
            new $web;
        }
        Settings::setLocale(config('app.locale'));
        include route_path('/web.php');
        }
    public function apiٌRout(){
        foreach(\App\Core::$globapi as $api){
            new $api;
        }
        include route_path('/api.php');
    }
}
