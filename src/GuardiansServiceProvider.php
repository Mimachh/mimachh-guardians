<?php

namespace Mimachh\Guardians;

use Mimachh\Guardians\Console\ManageGuardians;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Mimachh\Guardians\Console\SeedRolesCommand;
use Mimachh\Guardians\Http\Middleware\CheckRoleMiddleware;
use Mimachh\Guardians\Observers\UserObserver;

class GuardiansServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */

    public function boot()
    {
        // $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        // Charger les migrations
        $this->loadMigrationsFrom(__DIR__ . '/./database/migrations');

        User::observe(UserObserver::class);
        
        // Charger les seeders
        $this->publishes([
            __DIR__ . '/./database/seeders' => database_path('seeders'),
        ], 'guardians-seeders');

        $this->publishes([
            __DIR__ . '/../config/guardians.php' => config_path('guardians.php'),
        ], 'guardians-config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                SeedRolesCommand::class,
                ManageGuardians::class,
            ]);
        }

        $router = $this->app['router'];
        $router->aliasMiddleware('checkRole', CheckRoleMiddleware::class);
        
    }

    public function register()
    {
        //
    }
}
