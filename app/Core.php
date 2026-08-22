<?php
    namespace App;

    class Core{
        public static $globweb = [
            \illuminates\sessions\Session::class
        ];
         public static $middlewareWebRout = [
           "Simple" => \App\Http\Middlewares\Simple::class,
        ];
        
        public static $globapi = [
           
        ];

    }