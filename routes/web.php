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


$router->get('/lists', 'ToDoController@getLists');
$router->get('/list/{id}', 'ToDoController@getList');
$router->post('/user/', 'UserController@saveUser');
$router->delete('/user/{id}', 'UserController@deleteUser');
$router->patch('/user/{id}', 'UserController@updateUser');
