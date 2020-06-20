<?php

namespace App\Models;

use Spatie\Permission\Models\Role as Model;

class Role extends Model
{
    /**
     * Set permissions guard to API by default
     * @var string
     */
    protected $guard_name = 'api';
}
