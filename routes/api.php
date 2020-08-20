<?php

use GuzzleHttp\Middleware;
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

Route::namespace('API')->group(function () {
    /*
    * Auth Routes
    */
    Route::post('auth/login', 'Auth\AuthController@login');
    Route::get('auth/user', 'Auth\AuthController@auth');
    Route::post('auth/logout', 'Auth\AuthController@logout');

    /*
    * Admin Routes
    */
    Route::namespace('Admin')->middleware('auth:sanctum')->group(function () {
        includeRouteFiles(__DIR__ . '/Admin/');
    });
});
