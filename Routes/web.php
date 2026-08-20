<?php

use \app\Http\Middlewares\Simple;
use \illuminates\Router\Rout;
use \App\Http\Controllers\HomeController;

Rout::get( "/", HomeController::class, 'index');
   // Rout::get( "/", fn()=>'index of closure');
Rout::get("about", HomeController::class, 'about', [Simple::class]);
   // Rout::get("about", function(){return 'about from closure';});
Rout::get("article/{id}", HomeController::class, 'article');
   // Rout::get("article/{id}", function($id){return "article $id from closure";});