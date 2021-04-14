<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

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
     * Associate many roles to an user.
     * @return \App\Role
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Verify if a user has any of the roles in the array
     * @param array $roles
     * @return Bolean
     */
    public function hasAnyRoles($roles)
    {
        if ($this->roles()->whereIn('name', $roles)->first()) {
            return true;
        }

        return false;
    }

    /**
     * Verify if a user has any of the roles in the array
     * @param String $role
     * @return bool
     */
    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }

        return false;
    }

    /**
     * Verify if the user has admin role.
     * @return bool
     */
    public function isAdministrator()
    {
        if ($this->roles()->where('name', Role::ROLE_ADMIN)->first()) {
            return true;
        }

        return false;
    }
}
