<?php

namespace Mimachh\Guardians;

use Mimachh\Guardians\Role;

trait HasRoles
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function assignRole($role)
    {
        return $this->roles()->attach($role);
    }

    public function assignRoles($roles)
    {
        return $this->roles()->sync($roles);
    }

    public function removeRole($role)
    {
        return $this->roles()->detach($role);
    }

    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }
}
