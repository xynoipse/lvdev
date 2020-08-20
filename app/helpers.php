<?php

/**
 * Global helpers file with misc functions.
 */
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

if (!function_exists('appPath')) {
    /**
     * Helper to grab the application path.
     */
    function appPath()
    {
        return config('app.path');
    }
}

if (!function_exists('includeRouteFiles')) {

    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function includeRouteFiles($folder)
    {
        $directory = $folder;
        $handle = opendir($directory);
        $directory_list = [$directory];

        while (false !== ($filename = readdir($handle))) {
            if ($filename != '.' && $filename != '..' && is_dir($directory . $filename)) {
                array_push($directory_list, $directory . $filename . '/');
            }
        }

        foreach ($directory_list as $directory) {
            foreach (glob($directory . '*.php') as $filename) {
                require $filename;
            }
        }
    }
}
