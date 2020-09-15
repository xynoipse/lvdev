<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Access Control List
 */
final class Acl
{
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

    /**
     * @return array
     */
    public static function roles(): array
    {
        try {
            $class = new \ReflectionClass(__CLASS__);
            $constants = $class->getConstants();
            $roles =  Arr::where($constants, function ($value, $key) {
                return Str::startsWith($key, 'ROLE_');
            });

            return array_values($roles);
        } catch (\ReflectionException $exception) {
            return [];
        }
    }
}
