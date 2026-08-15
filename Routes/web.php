<?php
use \illuminates\Router\Rout;
use \App\Http\Controllers\HomeController;

    Rout::get( "/", HomeController::class, 'index');
    Rout::get("about", HomeController::class, 'about');
    Rout::get("article/{id}", HomeController::class, 'article');