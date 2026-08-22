<?php

namespace illuminates\middleware;
use \App\Core;


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
                    var_dump($middleware);
                    return (new $middleware)->handle($request, $next, $role);
                };
            }
        }
        return $next;
    }

    public static function getFromCore(string $key){
        if(isset(Core::$middlewareWebRout[$key])){
            return Core::$middlewareWebRout[$key];
        }else{
            throw new \Exception("there is no class named $key");
        }
    }
}
