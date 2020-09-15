<?php

use Carbon\Carbon;

if (!function_exists('appName')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function appName()
    {
        return config('app.name');
    }
}

if (!function_exists('appRoute')) {
    /**
     * Helper to grab the application path.
     * 
     * @return mixed
     */
    function appRoute()
    {
        return config('app.route');
    }
}
