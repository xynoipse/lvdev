<?php

namespace App\Models\Access\Permission;

use Spatie\Permission\Models\Permission as Model;

class Permission extends Model
{
    /**
     * Set permissions guard to API by default
     * @var string
     */
    protected $guard_name = 'api';
}
