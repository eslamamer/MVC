<?php
    namespace illuminates\sessions;

use illuminates\hashes\Hash;

    class session{
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

        public static function get(string $key): mixed{
            return isset($_SESSION[$key]) ? Hash::decrypt($_SESSION[$key]) : $key;
        }

        public static function has(string $key, mixed $val = null): mixed{
            if(!is_null($val)){
                $_SESSION[$key] = Hash::encript($val);
            }
            $session = isset($_SESSION[$key]) ? Hash::decrypt($_SESSION[$key]) : '';
            self::forget($key);
            return $session;
        }

       public static function forget(string $key): void{
           if (isset($_SESSION[$key])){
                unset($_SESSION[$key]);
           } 
        }
        public static function forget_all():void{
            session_destroy();
        }
        
    }