<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/php',function(){
    phpinfo();
});

$router->post('/search','SearcherController@search');

$router->post('/estadistica','SearcherController@estadistica');

$router->get('/es','SearcherController@estadistica');

