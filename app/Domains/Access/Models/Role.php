<?php

namespace App\Domains\Access\Models;

use App\Domains\Access\Models\Traits\Attribute\RoleAttribute;
use App\Domains\Access\Models\Traits\Method\RoleMethod;
use App\Domains\Access\Models\Traits\Scope\RoleScope;
use Spatie\Permission\Models\Role as Model;

class Role extends Model
{
    use RoleAttribute,
        RoleMethod,
        RoleScope;

    /**
     * Set permissions guard to API by default
     * 
     * @var string
     */
    protected $guard_name = 'api';
}
