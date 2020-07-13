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

    /**
     * Check if role is admin/superadmin
     * @return bool
     */
    public function isAdmin($super = null)
    {
        $admin = ['superadmin', 'admin'];
        if ($super == 'super') $admin = ['superadmin'];
        return in_array($this->name, $admin);
    }
}
