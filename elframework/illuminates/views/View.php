<?php
    namespace illuminates\views;

    class View{

    
        /**
         * @param string $view
         * @param array $data
         * 
         * @return void
         */
        public static function make(string $view, array $data = []):void{
            $view = str_replace('.', '/', $view);
            $path = config('views.path');
            extract($data);
            include $path.'/'.$view.'.tpl.php';
        }
    }