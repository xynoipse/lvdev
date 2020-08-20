<?php

namespace App\Models\Access\User;

use App\Acl;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, Notifiable;

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
     * @var string
     */
    protected $guard_name = 'api';

    /**
     * Check if user role is admin/superadmin
     * @return bool
     */
    public function isAdmin($super = null)
    {
        $admin = [Acl::ROLE_SUPERADMIN, Acl::ROLE_ADMIN];
        if ($super == 'super') $admin = Acl::ROLE_SUPERADMIN;
        return $this->hasRole($admin);
    }
}
