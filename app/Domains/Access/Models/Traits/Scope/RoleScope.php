<?php

namespace App\Domains\Access\Models\Traits\Scope;

trait RoleScope
{
    /**
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $query->where('name', 'LIKE', "%$search%");
        });
    }
}
