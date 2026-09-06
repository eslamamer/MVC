<?php
    namespace illuminates\views;

    class View{

        protected static string $cachePath;

        /**create caching folder if not exists
         * void
         */
        public static function prepCache():void{
            static::$cachePath = config('views.cache');
            if(!is_dir(static::$cachePath)){
                mkdir(static::$cachePath, 0755,true);
            }
        }

        /**
         * @param string $view
         * @param array $data
         * generate cashing file as string
         * @return string
         */
        protected static function generateCache(string $view, array $data = []):string{
            $view = str_replace('.', '/', $view);
            $path = config('views.path');
            extract($data);
            ob_start();
            include $path.'/'.$view.'.tpl.php';
            return ob_get_clean();
        }

        /**
         * @param string $file
         * 
         * @return bool
         */
        public static function isValid(string $file):bool{
            return file_exists($file);
        }

        public static function fileFullName(string $name){
            return $name."cached.php";
        }
    
        /**
         * @param string $view
         * @param array $data
         * 
         * @return string
         */
        public static function make(string $view, array $data = []):string{
            if(config('views.cached')){
                static::prepCache(); 
                $file = static::fileFullName(static::$cachePath.'/'.md5(config('views.path').$view));
                if(static::isValid($file)){
                    var_dump($file);
                    return include $file;
                }else{
                    $output = static::generateCache($view, $data); 
                    file_put_contents($file ,$output);
                    return $output;
                }
            }else{
                $view = str_replace('.', '/', $view);
                $path = config('views.path');
                var_dump($path.'/'.$view);
                extract($data);
                return include $path.'/'.$view.'.tpl.php';
            }
        }
    }