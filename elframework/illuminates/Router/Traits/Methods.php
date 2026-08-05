<?php
    namespace illuminates\Router\Traits;
    
    trait Methods{
         /**
         * @param string $route
         * @param string $controller
         * @param string $action
         * @param array array
         * 
         * @return void
         */
        public static function get( string $route , string $controller , string $action , array $middleware =[]):void{
            parent::add("GET", $route ,  $controller , $action , $middleware);
        }
        /**
         * @param string $route
         * @param string $controller
         * @param string $action
         * @param array array
         * 
         * @return void
         */
        public static function post( string $route , string $controller , string $action , array $middleware =[]):void{
            parent::add("POST", $route ,  $controller , $action , $middleware);
        }
        /**
         * @param string $route
         * @param string $controller
         * @param string $action
         * @param array array
         * 
         * @return void
         */
        public static function put( string $route , string $controller , string $action , array $middleware =[]):void{
            parent::add("PUT", $route ,  $controller , $action , $middleware);
        }
        /**
         * @param string $route
         * @param string $controller
         * @param string $action
         * @param array array
         * 
         * @return void
         */
        public static function patch( string $route , string $controller , string $action , array $middleware =[]):void{
            parent::add("PATCH", $route ,  $controller , $action , $middleware);
        }
        /**
         * @param string $route
         * @param string $controller
         * @param string $action
         * @param array array
         * 
         * @return void
         */
        public static function delete( string $route , string $controller , string $action , array $middleware =[]):void{
            parent::add("DELETE", $route ,  $controller , $action , $middleware);
        }
    }