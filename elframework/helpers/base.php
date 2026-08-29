<?php
use illuminates\logs\Log;

if (!function_exists('view')) {
    function view(string $view, array $data = [])
    {
        return \illuminates\views\View::make($view, $data);
    }
}

if (!function_exists('base_path')) {
    function base_path($file = null)
    {
        return ROOT_PATH."/../$file";
    }
}

if(!function_exists('uri')){
    /**
     * @param string $uri
     * 
     * @return string
     */
    function uri(string $uri):string{
        return $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].ROOT.ltrim($uri, '/');
    }   
}

if (!function_exists('route_path')) {
    /**
     * @param string $file
     * 
     * @return string
     */
    function route_path(string $file = ""):string
    {
        return !empty($file) ? config('router.path') . $file : config('router.path');
    }
}

if (!function_exists('storage_path')) {
    /**
     * @param string $file
     * 
     * @return string
     */
    function storage_path(string $file = ""):string
    {
        return !empty($file) ? config('storage.path')."/" . $file : config('storage.path');
    }
}

if (!function_exists('config')) {
    /**
     * @param string $str_path
     * 
     * @return string
     */
    function config(string $str_path): string {
        static $cache = [];
        if (isset($str_path)) {
            $sep  = explode('.', $str_path);
            $name = $sep[0];
            $path = $sep[1] ?? null;
            if (isset($cache[$name])) {
                return $cache[$name][$path] ?? $str_path;
            } else {
                $file = base_path('config/') . $name . ".php";
                if (file_exists($file)) {
                    $cache[$name] = require_once $file;
                    return isset($cache[$name][$path]) ? $cache[$name][$path] : $str_path;
                } else {
                    throw new Log($name." not exist");
                }
            }
        } else {
            return "";
        }
    }
}

if (!function_exists('public_path')) {
    function public_path(string $path = "")
    {
        return !empty($path) ? ROOT_PATH . "/" . $path : ROOT_PATH;
    }
}

if (!function_exists('bcrypt')){
    function bcrypt(string $password){
        return \illuminates\hashes\Hash::make($password);
    }
}
if (!function_exists('check_hash')){
    function check_hash(string $password, string $hashed){
        return \illuminates\hashes\Hash::check($password, $hashed);
    }
}
if (!function_exists('encript')){
    function encript(string $val){
        return \illuminates\hashes\Hash::encript($val);
    }
}
if (!function_exists('decript')){
    function decript(string $val){
        return \illuminates\hashes\Hash::decrypt($val);
    }
}