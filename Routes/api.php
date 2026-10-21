<?php

use App\Http\Controllers\HomeController;
use \illuminates\Router\Rout;
    //use \App\Http\Middlewares\Api;
    use \App\Http\Middlewares\Simple;
    use \App\Http\Middlewares\User;
    use \illuminates\views\Settings;
    //use \illuminates\sessions\Session;

    Rout::group(['prefix' => 'api', 'middleware' => [Simple::class] ], function(){
        Rout::get("/", function(){
            return Settings::getLocale();
        });

        // Rout::get("users", function(){
        //     return "welcome to api users";
        // },middleware:[User::class]);

        Rout::get("users",  HomeController::class, 'api_any' ,[User::class]);
    });