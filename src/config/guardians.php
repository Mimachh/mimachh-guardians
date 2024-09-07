<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Role Model
    |--------------------------------------------------------------------------
    |
    | This is the Role model that is used to create and manage user roles.
    | You can change the model here to use a custom Role model if necessary.
    |
    */
    'role_model' => \Mimachh\Guardians\Models\Role::class,

    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    |
    | This is the User model that will have the roles attached to it.
    | You can change the model here to use a custom User model if necessary.
    |
    */
    'user_model' => \App\Models\User::class,

    /*
    |--------------------------------------------------------------------------
    | Default Roles
    |--------------------------------------------------------------------------
    |
    | These roles will be seeded into the database when the seeders are run.
    | Each role is defined with a name and a slug.
    |
    */
    'default_roles' => [
        [
            'name' => 'admin',
            'slug' => 'admin',
        ],
        [
            'name' => 'editor',
            'slug' => 'editor',
        ],
        [
            'name' => 'user',
            'slug' => 'user',
        ],
    ],



    /*
    |--------------------------------------------------------------------------
    | Default Attach After User Created
    |--------------------------------------------------------------------------
    |
    | These role will be attached to the user after the user is created.
    | You can change it.
    |
    */
    'default_roles_attached' => [
        'user'
    ],

    /*
    |--------------------------------------------------------------------------
    | Pivot Table Name
    |--------------------------------------------------------------------------
    |
    | The name of the pivot table that will be used to store the role_user 
    | relationships.
    |
    */
    'role_user_table' => 'role_user',

    /*
    |--------------------------------------------------------------------------
    | Cache Settings
    |--------------------------------------------------------------------------
    |
    | Here you may define the cache settings for roles and permissions.
    | This can help improve performance by reducing the number of queries.
    |
    */
    'cache' => [
        'enabled' => true,
        'expiration' => 60, // minutes
    ],

];
