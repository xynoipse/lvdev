<?php

namespace App\Domains\Access\Models\Traits\Method;

use App\Acl;

trait UserMethod
{
    /**
     * @return bool
     */
    public function isMasterAdmin(): bool
    {
        return $this->id === 1 && $this->hasRole(Acl::ROLE_ADMIN);
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole(Acl::ROLE_ADMIN);
    }

    /**
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->hasRole(Acl::ROLE_USER);
    }
}
