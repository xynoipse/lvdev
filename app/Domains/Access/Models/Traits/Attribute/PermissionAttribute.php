<?php

namespace App\Domains\Access\Models\Traits\Attribute;

trait PermissionAttribute
{
    /**
     * @param $name
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }
}
