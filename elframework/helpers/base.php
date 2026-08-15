<?php
if (!function_exists('base_path')) {
    function base_path($file = null)
    {
        return getcwd() . "/../$file";
    }
}

if (!function_exists('route_path')) {
    function route_path(string $file = "")
    {
        return !empty($file) ? config('router.path') . $file : config('router.path');
    }
}

if (!function_exists('config')) {
    function config(string $str_path): string
    {
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
                    throw new \Exception($name . " not exist");
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
        return !empty($path) ? getcwd() . "/" . $path : getcwd();
    }
}
