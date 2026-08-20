<?php
    namespace app\Http\Middlewares;
    use \contracts\Middleware;

    class Simple implements Middleware{
        public function handle(string $request, mixed $next)
        {
            if(2==2){
                header('location: '.uri('/'));
                exit;
            }
            return $next($request); 
        }
    }