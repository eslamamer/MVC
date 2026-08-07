<?php
    if(!function_exists('base_path')){
       function base_path($file = null){
                    return getcwd()."/../$file";
                }
    }

    if(!function_exists('route_path')){
        function route_path(){
            return config('router.path');
        }
    }

    if(!function_exists('config')){
        function config(string $path){
            if(!is_null($path)){
                $sep      = explode('.', $path);
                $file = require_once base_path('config/').$sep[0].".php";
                if(!empty($file)){
                    return isset($file[$sep[1]]) ? $file[$sep[1]] : $path;
                }else{
                    throw new \Exception($sep[0]."not exist");
                }
             }
         }
    }