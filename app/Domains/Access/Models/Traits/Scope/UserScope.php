<?php

namespace App\Domains\Access\Models\Traits\Scope;

trait UserScope
{
    /**
     * @param $query
     * @param $role
     * @return mixed
     */
    public function scopeByRole($query, $role)
    {
        return $query->whereHas('roles', function ($query) use ($role) {
            $query->where('name', $role);
        });
    }

    /**
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $query->where('name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%");
        });
    }
}
