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
    
    public static function routes(){
        return self::$routes;
    }

    /**
     * @param string $uri
     * @param mixed $method
     * 
     * @return mixed
     */
    public static function dispatch(string $uri,mixed $method){
        $uri = str_starts_with($uri, static::public_path("/elframe")) ? substr($uri, strlen(static::public_path("/elframe"))) : $uri;
        foreach(self::routes()[$method] as $key => $value){
            $pattern    = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_]+)', $key);
            $pattern    = "#^$pattern$#";
            if(preg_match($pattern, $uri, $matches)){
                $controller = $value['controller'];
                $action     = $value['action'];
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                return call_user_func_array([new $controller, $action], $params);
            }
        }
        throw new \Exception($uri." not Existing Rout");
    }
}