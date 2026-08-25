<?php

use \App\Http\Middlewares\Simple;
use \illuminates\Router\Rout;
use \App\Http\Controllers\HomeController;

Rout::get( "/", HomeController::class, 'index', ["Simple, admin"] );
// Rout::get( "/", fn()=>'index of closure', middleware:[Simple::class]);
// Rout::get("about", HomeController::class, 'about', [Simple::class]);
Rout::get("about", function(){return 'about from closure';}, middleware:["Simple"]);
// Rout::get("article/{id}", HomeController::class, 'article', [Simple::class]);
Rout::get("article/{id}", function($id){return "article $id from closure";}, middleware:[Simple::class]);