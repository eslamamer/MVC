<?php

namespace illuminates\middleware;
use \App\Core;


class Middleware
{

    public static function handleMiddleware(array $middlewares, object $next, string $type)
    {
        if (is_array($middlewares) && !empty($middlewares)) {
            foreach (array_reverse($middlewares) as $middleware) {
                $next = function ($request) use ($middleware, $next, $type) {
                    $role = explode(',', $middleware);
                    $middlewareKey = array_shift($role);
                    if(!class_exists($middlewareKey)){
                        $middleware = self::getFromCore($middlewareKey, $type);
                    }
                    return (new $middleware)->handle($request, $next, $role);
                };
            }
        }
        return $next;
    }

    public static function getFromCore(string $key, string $type = 'web'){
        if($type == 'web' && isset(Core::$middlewareWebRout[$key])){
            return Core::$middlewareApiRout[$key];
        }elseif($type == 'api' && isset(Core::$middlewareApiRout[$key])){
            return Core::$middlewareWebRout[$key];
        }else{
            throw new \Exception("there is no class named $key");
        }
    }
}
