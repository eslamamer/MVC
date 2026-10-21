<?php
    namespace App\Http\Middlewares;
    use \contracts\middleware\Contract;
    use \illuminates\views\Settings;
    class Simple implements Contract{

        public function handle(string $request, mixed $next, array $role)
        {
            Settings::setLocale($_GET['lang']);
        //    if(trim($role[0]) == "admin"){
        //         header('location: '.uri('about'));
        //         exit;
        //     }
            return $next($request); 
        }
    }