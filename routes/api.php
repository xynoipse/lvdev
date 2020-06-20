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

Route::namespace('API')->group(function () {
    Route::post('auth/login', 'Auth\AuthController@login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('auth/user', 'Auth\AuthController@auth');
        Route::post('auth/logout', 'Auth\AuthController@logout');

        Route::apiResource('users', 'UserController');
        Route::apiResource('roles', 'RoleController');
        Route::apiResource('permissions', 'PermissionController');
    });
});
