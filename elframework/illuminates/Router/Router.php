<?php

namespace illuminates\Router;

use Closure;
use \illuminates\middleware\Middleware;


class Router
{
    protected static $routes    = [];
    protected static $groupattr = [];

    private static string $public;

    /**
     * @return string
     */
    public static function public_path($bind = null): string
    {
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
    public static function add(string $method, string $route, mixed $controller, mixed $action = null, $middleware = []): void
    {
        $route = self::applyGroupPrefix($route);
        $middleware = self::applyMiddleware($middleware);
        // $route = "/" . ltrim($route, '/');
        // self::$routes[$method][$route] = compact('controller', 'action', 'middleware');
        self::$routes[] = [
            "method"     => $method,
            "uri"        => $route,
            "controller" => $controller,
            "action"     => $action,
            "middleware" => $middleware
        ];
    }

    public static function routes()
    {
        return self::$routes;
    }

    public static function group(array $attr, Closure $callback){
        $previousGroupAttr = static::$groupattr;
        static::$groupattr = array_merge(static::$groupattr, $attr);
        call_user_func($callback, new self);
        static::$groupattr = $previousGroupAttr;
    }

    protected static function applyGroupPrefix(string $route){
        if(isset(self::$groupattr['prefix'])){
            $full_route = rtrim(self::$groupattr['prefix'], '/').'/'.ltrim($route, '/');
            return $full_route;
        }else{
            return $route;
        }
    } 

    protected static function applyMiddleware(array $middleware){
        if(isset(self::$groupattr['middleware'])){
            $apiMiddleware = self::$groupattr['middleware']??[];
            return array_merge($apiMiddleware, $middleware);
        }
        return $middleware;
    } 

    /**
     * @param string $uri
     * @param mixed $method
     * 
     * @return mixed
     */
    public static function dispatch(string $uri, string $method, string $type)
    {
        // echo "<pre>";
        //  var_dump(static::routes());
    
        $uri = str_starts_with($uri, static::public_path("/elframe")) ? substr($uri, strlen(static::public_path("/elframe"))) : $uri;
        foreach (self::routes() as $value) {
            if($value['method'] == $method){
                $pattern    = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_]+)', $value['uri']);
                $pattern    = "#^$pattern$#";
                $controller = $value['controller'];
                $action     = $value['action'];
                $middlewares = $value['middleware'];
                if (preg_match($pattern, $uri, $matches)) {
                    var_dump($matches);
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    if (is_object($controller)) {
                        $next = function ($request) use ($controller, $params) {
                            return $controller(...$params);
                        };
                    } else {
                        $next = function ($request) use ($controller, $action, $params) {
                            return call_user_func_array([new $controller, $action], $params);
                        };
                    }
                    $next = Middleware::handleMiddleware($middlewares, $next, $type);
                    return $next($uri);
                }
            }else{
                throw new \Exception($uri . " not Existing Rout");
            } 
        }

    }
}
