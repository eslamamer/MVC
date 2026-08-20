<?php
use \illuminates\Router\Rout;
//use \App\Http\Controllers\HomeController;

Rout::get( "/", \App\Http\Controllers\HomeController::class, 'index');
   // Rout::get( "/", fn()=>'index of closure');
Rout::get("about", \App\Http\Controllers\HomeController::class, 'about');
   // Rout::get("about", function(){return 'about from closure';});
Rout::get("article/{id}", \App\Http\Controllers\HomeController::class, 'article');
   // Rout::get("article/{id}", function($id){return "article $id from closure";});