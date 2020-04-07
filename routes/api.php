<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->group(function () {
    Route::apiResource('/categories', 'CategoryController');
    Route::post('/statistics', 'StatisticController@makeMoney');

    Route::get('/sites', 'SiteController@index');
    Route::get('/sites/current', 'SiteController@currentSite');
    Route::get('/sites/change', 'SiteController@changeSite');
});
