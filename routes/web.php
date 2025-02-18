<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
    return ["Hello Hai..!!!"];
});

$router->get('/user', function () use ($router) {
    $results = app('db')->select("SELECT * FROM users");
    return response()->json($results);
});

$router->post('/register', 'UserController@register');
$router->post('/login','AuthController@login');


$router->group(['middleware' => 'auth'], function() use ($router){
    $router->post('/logout', 'AuthController@logout');
    $router->get('api/user', 'UserController@show');
    $router->post('api/ubahDataDiri', 'UserController@ubahDataDiri');
    $router->post('api/ubahSandi', 'UserController@ubahSandi');
    
    $router->get('api/kebutuhan/{kategori}','KebutuhanController@kebutuhan');
    $router->get('api/detailKebutuhan/{id}','KebutuhanController@detailKebutuhan');
});
