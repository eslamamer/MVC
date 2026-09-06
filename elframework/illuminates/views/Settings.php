<?php
    namespace illuminates\views;
    use \illuminates\sessions\Session;

    class Settings{
        public static function setTimeZone(){
            date_default_timezone_set(config('app.timezone'));
        }

         public static function getTimeZone(){
            date_default_timezone_get();
        }

        public static function getLocale(){
            return Session::has('locale') ? Session::get('locale') : config('app.locale');
        }

        public static function setLocale(string $locale){
            Session::make('locale', $locale);
            return Session::get('locale');
        }
    }

    