<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Access')->group(function () {
    /**
     * Users
     */
    Route::apiResource('users', 'UserController');
    Route::get('users/{user}/permissions', 'UserController@permissions');
    Route::match(['put', 'patch'], 'users/{user}/permissions', 'UserController@updatePermissions');

    /**
     * Profile
     */
    Route::match(['put', 'patch'], 'profile', 'UserController@updateProfile');

    /**
     * Roles
     */
    Route::apiResource('roles', 'RoleController');
    Route::get('roles/{role}/permissions', 'RoleController@permissions');
    Route::match(['put', 'patch'], 'roles/{role}/permissions', 'RoleController@updatePermissions');

    /**
     * Permissions
     */
    Route::apiResource('permissions', 'PermissionController');
});
