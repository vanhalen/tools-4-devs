<?php

use Illuminate\Support\Facades\Route;
$router->group(['middleware' => 'language'], function () use ($router) {
    $router->get('/', function () {
        return view('welcome');
    });
});

$router->aliasMiddleware('language', \App\Http\Middleware\LanguageSwitcher::class);
