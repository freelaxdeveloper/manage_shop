<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('/categories', 'CategoryController');
    $router->resource('/sites', 'SiteController');
    $router->resource('/statistics', 'StatisticController');
    $router->resource('/plans', 'PlanController');
    $router->resource('/users', 'UserController');

});
