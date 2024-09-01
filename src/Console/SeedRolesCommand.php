<?php

namespace Mimachh\Guardians\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SeedRolesCommand extends Command
{
    protected $signature = 'guardians:seed';

    protected $description = 'Seed default roles for the Guardians package';

    public function handle()
    {
        $this->info('Seeding roles...');

        Artisan::call('db:seed', [
            '--class' => 'Mimachh\Guardians\Database\Seeders\RoleSeeder'
        ]);

        $this->info('Roles seeded successfully!');
    }
}
