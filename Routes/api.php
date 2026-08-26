<?php
   use \illuminates\Router\Rout;
//    use \App\Http\Middlewares\Api;
   use App\Http\Middlewares\Simple;

   Rout::group(['prefix' => 'api', 'middleware' => [Simple::class] ], function(){
        Rout::get("/", function(){
            return "welcome to api";
        });

        Rout::get("users", function(){
            return "welcome to api users";
        });
   });