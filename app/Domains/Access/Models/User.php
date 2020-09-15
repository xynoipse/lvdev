<?php

namespace App\Domains\Access\Models;

use App\Domains\Access\Models\Traits\Attribute\UserAttribute;
use App\Domains\Access\Models\Traits\Method\UserMethod;
use App\Domains\Access\Models\Traits\Scope\UserScope;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable,
        HasRoles,
        UserAttribute,
        UserMethod,
        UserScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Set permissions guard to API by default
     * 
     * @var string
     */
    protected $guard_name = 'api';
}
