<?php

namespace Mimachh\Guardians\Console;

use App\Models\User;
use Illuminate\Console\Command;
use Mimachh\Guardians\Role;

class ManageGuardians extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'guardians:manage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add or remove roles for a specific user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->ask('Please enter the email of the user');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error('User not found.');
            return;
        }

        // Affiche les rôles de l'utilisateur
        $userRoles = $user->roles()->pluck('name')->toArray();
        if (empty($userRoles)) {
            $this->info("User '{$user->email}' has no roles.");
        } else {
            $this->info("User '{$user->email}' has the following roles: " . implode(', ', $userRoles));
        }

        // Affiche les rôles disponibles
        $roles = Role::all()->pluck('name')->toArray();
        $this->info('Available roles: ' . implode(', ', $roles));

        // Demande l'action à effectuer : ajouter ou retirer un rôle
        $action = $this->choice(
            'Would you like to add or remove a role?',
            ['add', 'remove'],
            0
        );

        // Demande quel rôle ajouter ou retirer
        $roleName = $this->ask('Which role?');

        // Vérifie que le rôle existe
        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            $this->error('Role not found.');
            return;
        }

        // Ajouter ou retirer le rôle
        if ($action === 'add') {
            if (!$user->roles->contains($role->id)) {
                $user->roles()->attach($role);
                $this->info("Role '{$roleName}' has been added to user '{$user->email}'.");
            } else {
                $this->error("User already has the role '{$roleName}'.");
            }
        } elseif ($action === 'remove') {
            if ($user->roles->contains($role->id)) {
                $user->roles()->detach($role);
                $this->info("Role '{$roleName}' has been removed from user '{$user->email}'.");
            } else {
                $this->error("User doesn't have the role '{$roleName}'.");
            }
        }
    }
}
