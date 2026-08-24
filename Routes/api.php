<?php
   var_dump('api');
   use \illuminates\Router\Rout;
    Rout::get("/api", function(){
        return "welcome to api";
    });

    Rout::get("api/users", function(){
        return "welcome to api users";
    });