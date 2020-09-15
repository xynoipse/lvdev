<?php

namespace App\Domains\Access\Models\Traits\Attribute;

use Illuminate\Support\Facades\Hash;

trait UserAttribute
{
    /**
     * @param $name
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = ucwords($name);
    }

    /**
     * @param $password
     */
    public function setPasswordAttribute($password): void
    {
        // If password was accidentally passed in already hashed, try not to double hash it
        $this->attributes['password'] =
            (strlen($password) === 60 && preg_match('/^\$2y\$/', $password)) ||
            (strlen($password) === 95 && preg_match('/^\$argon2i\$/', $password))
            ? $password
            : Hash::make($password);
    }
}
