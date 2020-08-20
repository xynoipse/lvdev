<?php

namespace App\Models\Access\Role;

use App\Acl;
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
        $admin = [Acl::ROLE_SUPERADMIN, Acl::ROLE_ADMIN];
        if ($super == 'super') $admin = [Acl::ROLE_SUPERADMIN];
        return in_array($this->id, $admin);
    }
}
