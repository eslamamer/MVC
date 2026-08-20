<?php
    namespace illuminates\sessions;

use illuminates\hashes\Hash;

    class Session{

        public function  __construct(){
            session_save_path(config('session.path'));
            ini_set('session.gc_propability', 1);
            session_start([
                "cookie_lifetime" => config('session.expiration_timeout')
            ]);
        }
        /**
         * @param string $key
         * @param mixed|null $val
         * 
         * @return mixed
         */
        public static function make(string $key, mixed $val = null): mixed{
            if(!is_null($val)){
                $_SESSION[$key] = Hash::encript($val);
            }
            return isset($_SESSION[$key]) ? Hash::decrypt($_SESSION[$key]) : '';
        }

        /**
         * @param string $key
         * 
         * @return mixed
         */
        public static function get(string $key): mixed{
            return isset($_SESSION[$key]) ? Hash::decrypt($_SESSION[$key]) : $key;
        }

        /**
         * @param string $key
         * @param mixed|null $val
         * 
         * @return mixed
         */
        public static function has(string $key, mixed $val = null): mixed{
            if(!is_null($val)){
                $_SESSION[$key] = Hash::encript($val);
            }
            $session = isset($_SESSION[$key]) ? Hash::decrypt($_SESSION[$key]) : '';
            self::forget($key);
            return $session;
        }

       /**
        * @param string $key
        * 
        * @return void
        */
       public static function forget(string $key): void{
           if (isset($_SESSION[$key])){
                unset($_SESSION[$key]);
           } 
        }
        /**
         * @return void
         */
        public static function forget_all():void{
            session_destroy();
        }
        
    }