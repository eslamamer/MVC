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

    private static string $public;

    /**
     * @return string
     */
    public static function public_path($bind = null):string{
        static::$public = $bind ?? "/public/";
        return static::$public;
    }
    /**
     * @param string $method
     * @param string $route
     * @param string $controller
     * @param mixed $action
     * @param array $middleware
     * 
     * @return void
     */
    public static function add(string $method , string $route , string $controller , mixed $action , $middleware = []):void{
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
    public static function dispatch(string $uri,mixed $method){
        $uri  = "/".rtrim($uri, "/".static::public_path('elframe')."/");
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