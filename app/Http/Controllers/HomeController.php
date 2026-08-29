<?php
    namespace App\Http\Controllers;
    class HomeController{
        public function index(){
            $title = 'welcome to first view';
            $contents = 'my data content';
            return view('index', compact('title' , 'contents' ));
        }

        public function about(){
            return 'about action';
        }

        public function article(string $id){
            return 'article action '.$id;
        }
    }