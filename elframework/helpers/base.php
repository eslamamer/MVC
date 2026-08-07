<?php
    if(!function_exists('base_path')){
       function base_path($file = null){
                    return getcwd()."/../$file";
                }
    }

    if(!function_exists('config')){
        function config(string $path){
            $path      = explode('.', $path);
            $file = base_path('config/').$path[0]."php";
            var_dump($file[$path[1]]);
        }
    }