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
    public function add(string $method , string $route , string $controller , mixed $action , $middleware = []){
        $route = "/".ltrim($route, '/');
        $this->routes[$method][$route] = compact('controller', 'action', 'middleware');
    }
    
    public function routes(){
        return $this->routes;
    }

    public function dispatch(string $uri,mixed $method){
        $uri  = "/".ltrim($uri, '/');
        if(isset($this->routes[$method][$uri])){
            $data = $this->routes[$method][$uri];
            if(is_object($data['controller'])){
                return $data['action']();
            }else{
                call_user_func_array([new $data['controller'], $data['action']], []);
            }
        }else{
            throw new \Exception("$uri route not exist");
        }

    }
}