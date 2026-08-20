<?php
    namespace App\Http\Controllers;
    class HomeController{
        public function index(){
            echo 'index action';
        }

        public function about(){
            echo 'about action';
        }

        public function article(string $id){
            echo 'article action '.$id;
        }
    }