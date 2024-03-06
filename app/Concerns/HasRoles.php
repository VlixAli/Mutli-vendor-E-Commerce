<?php

namespace App\Concerns;

use App\Models\Role;

trait HasRoles
{
    public function roles()
    {
        return $this->morphToMany(Role::class, 'user', 'role_user');
    }

    public function hasAbility($ability)
    {
        $denied = $this->roles()->whereHas('abilities', function ($query) use ($ability) {
            $query->where('ability', $ability)
                ->where('type', '=', 'denied');
        })->exists();

        if($denied){
            return false;
        }

        return $this->roles()->whereHas('abilities', function ($query) use ($ability) {
            $query->where('ability', $ability)
                ->where('type', '=', 'allow');
        })->exists();
    }
}
