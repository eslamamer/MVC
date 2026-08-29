<?php

namespace illuminates\middleware;
use \App\Core;
use illuminates\logs\Log;


class Middleware
{

    public static function handleMiddleware(array $middlewares, object $next)
    {
        if (is_array($middlewares) && !empty($middlewares)) {
            foreach (array_reverse($middlewares) as $middleware) {
                $next = function ($request) use ($middleware, $next) {
                    $role = explode(',', $middleware);
                    $middlewareKey = array_shift($role);
                    if(!class_exists($middlewareKey)){
                        $middleware = self::getFromCore($middlewareKey);
                    }
                    return (new $middleware)->handle($request, $next, $role);
                };
            }
        }
        return $next;
    }

    public static function getFromCore(string $key){
        if( isset(Core::$middlewareWebRout[$key])){
            return Core::$middlewareWebRout[$key];
        }elseif((Core::$middlewareApiRout[$key])){
            return Core::$middlewareApiRout[$key];
        }else{
            throw new Log("there is no class named $key");
        }
    }
}
