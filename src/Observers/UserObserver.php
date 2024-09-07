<?php

namespace Mimachh\Guardians\Observers;

// use Illuminate\Support\Facades\Config;
use App\Models\User;
use Mimachh\Guardians\Models\Role;

class UserObserver
{
    /**
     * Handle event "created" for User Model.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $defaultRoles = config('guardians.default_roles_attached');

        foreach ($defaultRoles as $roleName) {
            $role = Role::where('slug', $roleName)->first();
            
            if ($role) {
                $user->roles()->attach($role);
            }
        }
    }
}
