<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Represents names of the roles.
    const ROLE_ADMIN = "admin";
    const ROLE_SUPERVISOR = "supervisor";
    const ROLE_STUDENT = "student";

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
