<?php

namespace App\Domains\Access\Models\Traits\Method;

use App\Acl;

trait RoleMethod
{
    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->name === Acl::ROLE_ADMIN;
    }
}
