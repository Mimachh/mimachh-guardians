# Mimachh/Guardians
Mimachh/Guardians is a Laravel package designed to simplify the management of user roles within your application. It provides an easy-to-use interface for associating roles with users, including methods for adding, removing, updating roles, and checking user roles. This package leverages a many-to-many relationship between users and roles to offer flexibility and control over user permissions.

## Features
- **Manage User Roles:** Easily add, remove, update, and manage user roles.
- **Many-to-Many Relationship:** Automatically handles the many-to-many relationship between users and roles.
- **Role Checking:** Provides methods to check user roles for use in policies, middlewares, controllers, and more.
- **Default Roles:** Automatically assign default roles to new users.
- **Configurable:** Customize role model, user model, default roles, and pivot table name via the config file.

## Installation
Install the package via Composer:

```php
composer require mimachh/guardians
```

Publish the package's configuration file:



```php
php artisan vendor:publish --tag=guardians-config
```


This will publish the configuration file to config/guardians.php.

Run the migrations:


```php
php artisan migrate
```
This will create the necessary tables for roles and the pivot table role_user.

## Register the Service Provider:

Add the service provider to the providers array in your config/app.php:

```php
'providers' => [
    // Other service providers...
    Mimachh\Guardians\GuardiansServiceProvider::class,
],
```
## Configuration
The configuration file `config/guardians.php` includes:

- role_model: The role model used by the package. By default, it uses \Mimachh\Guardians\Models\Role.
- user_model: The user model that will have roles attached. By default, it uses \App\Models\User.
- default_roles: Array of default roles to be seeded into the database. Format: [['name' => 'admin', 'slug' => 'admin'], ...].
- default_roles_attached: Roles to be automatically attached to new users upon creation.
- role_user_table: The name of the pivot table for the many-to-many relationship. Default is role_user.
- cache: Cache settings for roles and permissions to improve performance.

## Usage

## Use the trait
First you will need to add the trait `HasRoles` to the user model.

```php
use Mimachh\Guardians\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    // other configuration
}
```

## Seed the roles
You can seed the default roles using : 
```php
   php artisan guardians:seed
```

### Defining the Relationships
Ensure that your User and Role models define the many-to-many relationship:

#### User Model:
By default the relation `$user->roles()` is already loaded.
But you can override it, if you need to.

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // Define the many-to-many relationship with Role
    public function roles()
    {
        return $this->belongsToMany(\Mimachh\Guardians\Models\Role::class, config('guardians.role_user_table'));
    }
}
```

#### Role Model:
Relation is many to many, and the Role Model is already attach to user model.

```php
namespace Mimachh\Guardians\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Define the many-to-many relationship with User
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, config('guardians.role_user_table'));
    }
}
```
### Assigning Roles
#### Attach a role to a user:

```php
$user = App\Models\User::find(1);
$role = Mimachh\Guardians\Models\Role::where('slug', 'admin')->first();
$user->assignRole($role);

```

#### Attach several roles to a user:

```php
$user = App\Models\User::find(1);
$roles = ["user", "admin"];
$user->assignRoles($roles);

```

#### Detach a role from a user:

```php
$user->removeRole($role);
```

#### Check user role:

```php
if ($user->hasRole('slug')) {
    // User has the 'slug' role
}
```

### Using Observers
The package includes an observer to automatically assign default roles to new users:

```php
namespace Mimachh\Guardians\Observers;

use App\Models\User;
use Mimachh\Guardians\Models\Role;

class UserObserver
{
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

```

Ensure the observer is registered in the GuardiansServiceProvider:

```php
namespace Mimachh\Guardians;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Mimachh\Guardians\Observers\UserObserver;

class GuardiansServiceProvider extends ServiceProvider
{
    public function boot()
    {
        User::observe(UserObserver::class);
    }

    public function register()
    {
        // Register any bindings or services
    }
}
```
### Middleware
The package gives you a middleware to check the users's roles.

#### Register the middleware 
Give the middleware an alias :

```php
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'checkRole' => CheckRoleMiddleware::class
        ]);
    })
```

#### Use the middleware
Use it as you use any middleware, but ensure you pass the slug of the authorized role.

```php
Route::get('/', function () {
    return view('welcome');
})->middleware(['auth', 'checkRole:admin']);

```
### Testing
To test the package, you can create a new user and verify if the roles are attached correctly:

```php
php artisan tinker

$user = App\Models\User::create([
    'name' => 'Test User',
    'email' => 'testuser@example.com',
    'password' => bcrypt('password'),
]);

$user->roles; // Check if roles are attached
```

### Roadmap
Incoming : 
- Middleware to check is user have multiple roles eg. User must be ***author*** AND ***admin***

### Contributing
If you find any issues or have suggestions for improvements, please open an issue or submit a pull request on GitHub.

License
This package is licensed under the MIT License. See the LICENSE file for more details.
