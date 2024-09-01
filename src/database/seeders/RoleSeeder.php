<?php

namespace Mimachh\Guardians\Database\Seeders;

use Illuminate\Database\Seeder;
use Mimachh\Guardians\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultRoles = config('guardians.default_roles');
  
        foreach ($defaultRoles as $roleData) {
            Role::firstOrCreate([
                'name' => $roleData['name'],
                'slug' => $roleData['slug'],
            ]);
        }
    }
}
