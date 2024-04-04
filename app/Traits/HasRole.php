<?php

namespace App\Traits;

use App\Models\Role;

trait HasRole
{
    public function hasRole($role)
    {
        return $this->role()->where('role', $role)->exists();
    }

    public function hasAnyRole($roles)
    {
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }
        return false;
    }
}
