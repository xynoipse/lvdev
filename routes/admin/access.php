<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Access\Http\Controllers\API\Admin')->group(function () {
    /**
     * User
     */
    Route::namespace('User')->group(function () {
        Route::apiResource('users', 'UserController');
        Route::delete('users', 'UserController@massDestroy');

        Route::prefix('users/{user}')->group(function () {
            Route::get('permissions', 'UserPermissionController@show');
            Route::put('permissions', 'UserPermissionController@update');
            Route::put('password', 'UserPasswordController@update');
        });

        Route::put('profile', 'UserProfileController@update');
    });

    /**
     * Role
     */
    Route::namespace('Role')->group(function () {
        Route::apiResource('roles', 'RoleController');
        Route::delete('roles', 'RoleController@massDestroy');

        Route::prefix('roles/{role}')->group(function () {
            Route::get('permissions', 'RolePermissionController@show');
            Route::put('permissions', 'RolePermissionController@update');
        });
    });

    /**
     * Permission
     */
    Route::namespace('Permission')->group(function () {
        Route::apiResource('permissions', 'PermissionController');
        Route::delete('permissions', 'PermissionController@massDestroy');
    });
});
