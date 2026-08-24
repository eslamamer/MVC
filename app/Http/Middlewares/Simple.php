<?php
    namespace App\Http\Middlewares;
    use \contracts\middleware\Contract;
    class Simple implements Contract{

        public function handle(string $request, mixed $next, array $role)
        {
        //    if(trim($role[0]) == "admin"){
        //         header('location: '.uri('about'));
        //         exit;
        //     }
            return $next($request); 
        }
    }