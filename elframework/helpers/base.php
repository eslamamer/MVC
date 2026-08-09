<?php
    if(!function_exists('base_path')){
       function base_path($file = null){
                    return getcwd()."/../$file";
                }
    }

    if(!function_exists('route_path')){
        function route_path(string $file = ""){
            return !empty($file) ? config('router.path').$file : config('router.path');
        }
    }

    if(!function_exists('config')){
        function config(string $str_path):string{
            static $cache = [];
            if(isset($str_path)){
                $sep  = explode('.', $str_path);
                $name = $sep[0];
                $path = $sep[1] ?? null;
                if(isset($cache[$name])){
                    return $cache[$name][$path] ?? $str_path;
                }else{
                    $file = base_path('config/').$name.".php";
                    if(file_exists($file)){
                        $cache[$name] = require_once $file;
                        return isset($cache[$name][$path]) ? $cache[$name][$path] : $str_path;
                    }else{
                        throw new \Exception($name." not exist");
                    }
                }  
            }else{
                return "";
            }
         }
    }

    if(!function_exists('public_path')){
        function public_path(string $path = ""){
            return !empty($path) ? getcwd()."/".$path : getcwd();
        }
    }


// /* ============================================
//    دالة مساعدة مطلوبة للاختبار
//    ============================================ */
// function base_path($file = null) {
//     return "config/" === $file ? "config/" : "config/";
// }
// /* ============================================
//    الاختبار: نفس السيناريو على الدالتين
//    ============================================ */
// echo "=========== اختبار النسخة الجديدة المُصححة ===========\n";
// echo "router.path      => " . config_new('router.path') . "\n";
// echo "router.base_prefix => " . config_new('router.base_prefix') . "\n";
// echo "database.host    => " . config_new('database.host') . "\n"; // ملف مختلف تمامًا
// echo "router.path (مرة أخرى) => " . config_new('router.path') . "\n";

// echo "\n=========== اختبار النسخة القديمة المعطوبة ===========\n";
// try {
//     echo "router.path      => " . config_old('router.path') . "\n";
//     echo "database.host    => " . config_old('database.host') . "\n"; // سيفشل هنا
// } catch (\Throwable $e) {
//     echo "انهار الكود بخطأ: " . get_class($e) . " -> " . $e->getMessage() . "\n";
// }
// PHPEOF
// cd /home/claude/config_test2 && php final_comparison.php 2>&1
// Output

// =========== اختبار النسخة الجديدة المُصححة ===========
// router.path      => /Routes/web.php
// router.base_prefix => elframe
// database.host    => 127.0.0.1
// router.path (مرة أخرى) => /Routes/web.php

// =========== اختبار النسخة القديمة المعطوبة ===========
// انهار الكود بخطأ: TypeError -> file_exists(): Argument #1 ($filename) must be of type string, array given
