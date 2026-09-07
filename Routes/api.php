<?php
    use \illuminates\Router\Rout;
    //use \App\Http\Middlewares\Api;
    use \App\Http\Middlewares\Simple;
    use \illuminates\views\Settings;
    use \illuminates\sessions\Session;

    Rout::group(['prefix' => 'api', 'middleware' => [Simple::class] ], function(){
        Rout::get("/", function(){
            Settings::setLocale($_GET['lang']);
            return Settings::getLocale();
        });

        Rout::get("users", function(){
            return "welcome to api users";
        });
    });