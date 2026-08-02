<?php
namespace illuminates\Router;

class Router
{
    protected $routes = [
                    "GET"    => [],
                    "POST"   => [],
                    "PUT"    => [],
                    "PATCH"  => [],
                    "DELETE" => []
                ];
    public function add(string $method , string $route , string $controller , string $action , $middleware = []){
        $this->routes[$method][$route] = compact('controller', 'action', 'middleware');
    }

    public function routes(){
        return $this->routes;
    }
}