<?php

namespace App\Domains\Access\Models;

use App\Domains\Access\Models\Traits\Attribute\PermissionAttribute;
use App\Domains\Access\Models\Traits\Scope\PermissionScope;
use Spatie\Permission\Models\Permission as Model;

class Permission extends Model
{
    use PermissionAttribute,
        PermissionScope;

    /**
     * Set permissions guard to API by default
     * 
     * @var string
     */
    protected $guard_name = 'api';
}
