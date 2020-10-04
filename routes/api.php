<?php

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

Route::namespace('Domains')->group(function () {
    /**
     * Auth Routes
     */
    Route::prefix('auth')->namespace('Access\Http\Controllers\API\Auth')->group(function () {
        Route::post('login', 'AuthController@login');
        Route::get('user', 'AuthController@auth');
        Route::post('logout', 'AuthController@logout');
    });

    /**
     * Admin Routes
     */
    Route::middleware('auth:sanctum')->group(function () {
        includeRouteFiles(__DIR__ . '/admin');
    });
});
