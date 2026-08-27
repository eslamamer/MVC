<?php

namespace illuminates\Router;

use Closure;
use \illuminates\logs\Log;
use \illuminates\middleware\Middleware;


class Router
{
    protected static $routes    = [];
    protected static $groupattr = [];

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
        self::$routes[] = [
            "method"     => $method,
            "uri"        => "/" . ltrim($route, '/'),
            "controller" => $controller,
            "action"     => $action,
            "middleware" => $middleware
        ];
    }

    /**
     * @return array
     */
    public static function routes():array
    {
        return self::$routes;
    }

    /**
     * @param array $attr
     * @param Closure $callback
     * 
     * @return void
     */
    public static function group(array $attr, Closure $callback):void{
        $previousGroupAttr = static::$groupattr;
        static::$groupattr = array_merge(static::$groupattr, $attr);
        call_user_func($callback, new self);
        static::$groupattr = $previousGroupAttr;
    }

    /**
     * @param string $route
     * 
     * @return string
     */
    protected static function applyGroupPrefix(string $route):string{
        if(isset(self::$groupattr['prefix'])){
            $full_route = rtrim(self::$groupattr['prefix'].'/'.ltrim($route, '/'), '/') ?:'/';
            return $full_route;
        }else{
            return $route;
        }
    } 

    /**
     * @param array $middleware
     * 
     * @return array
     */
    protected static function applyMiddleware(array $middleware):array{
        if(isset(self::$groupattr['middleware'])){
            $apiMiddleware = self::$groupattr['middleware']??[];
            return array_merge($apiMiddleware, $middleware);
        }
        return $middleware;
    } 

    
    /**
     * @param string $uri
     * @param string $method
     * 
     * @return object
     */
    public static function dispatch(string $uri, string $method):mixed{
        $uri = str_starts_with($uri, ROOT) ? substr($uri, strlen(ROOT)) : $uri; 
        $uri = '/'.ltrim($uri, '/');
        foreach (self::routes() as $value) {
            $method = strtoupper($method);
            if($value['method'] == $method){
                $pattern    = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_]+)', $value['uri']);
                $pattern    = "#^$pattern$#";
                $controller = $value['controller'];
                $action     = $value['action'];
                $middlewares = $value['middleware'];
                if (preg_match($pattern, $uri, $matches)) { 
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    if (is_object($controller)) {
                        $next = function ($_request) use ($controller, $params) {
                            return $controller(...$params);
                        };
                    } else {
                        $next = function ($_request) use ($controller, $action, $params) {
                            return call_user_func_array([new $controller, $action], $params);
                        };
                    }
                    $next = Middleware::handleMiddleware($middlewares, $next);
                    return $next($uri);
                }
            } 
        }
        throw new Log($uri . " not Existing Rout");
        //throw new \Exception($uri . " not Existing Rout");
    }
}
 



