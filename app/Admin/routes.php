<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('variables', 'VariablesController');
    $router->resource('users', 'UsersController');
    $router->resource('orders', 'OrdersController');
    $router->resource('ingredients', 'IngredientsController');
    $router->resource('recipes', 'RecipesController');
    $router->resource('services', 'ServicesController');
});
