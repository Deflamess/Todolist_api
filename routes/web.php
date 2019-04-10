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

// Lists routes
$router->get('/lists', 'ListsController@getAllLists');
$router->get('/list/{id}', 'ListsController@getListById');
$router->post('/list', 'ListsController@saveList');
$router->delete('/list/{id}', 'ListsController@deleteList');
$router->put('/list/{id}', 'ListsController@updateList');

// Todo routes
$router->get('/todo/{id}', 'ToDoController@get');
$router->post('/todo', 'ToDoController@saveList');
$router->delete('/todo/{id}', 'ToDoController@deleteList');
$router->put('/todo/{id}', 'ToDoController@updateList');


