<?php
   namespace illuminates\Router;

   
   class Segment{

        public static function uri(){
                return str_starts_with($_SERVER['REQUEST_URI'], ROOT) ? substr($_SERVER['REQUEST_URI'], strlen(ROOT)) : $_SERVER['REQUEST_URI'];
        }

        public static function get(int $offset){
                $uri      = static::uri();
                $segments = explode("/",$uri);
                if(isset($segments[$offset])){
                        return parse_url($segments[$offset])['path'];
                }else{
                        return "";
                }
        }

        public static function all(){
                return explode("/", static::uri());
        }
    }

  