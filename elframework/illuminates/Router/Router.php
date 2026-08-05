<?php
namespace illuminates\Router;

class Router
{
    protected static $routes = [
                    "GET"    => [],
                    "POST"   => [],
                    "PUT"    => [],
                    "PATCH"  => [],
                    "DELETE" => []
                ];
    public static function add(string $method , string $route , string $controller , mixed $action , $middleware = []){
        $route = "/".ltrim($route, '/');
        self::$routes[$method][$route] = compact('controller', 'action', 'middleware');
    }
    
    public function routes(){
        return self::$routes;
    }

    /**
     * @param string $uri
     * @param mixed $method
     * 
     * @return mixed
     */
    public function dispatch(string $uri,mixed $method){
        $uri  = "/".ltrim($uri, '/');
        if(isset(self::$routes[$method][$uri])){
            $data = self::$routes[$method][$uri];
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