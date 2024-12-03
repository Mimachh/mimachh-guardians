<?php


namespace Mimachh\Guardians\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mimachh\Guardians\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Mimachh\Guardians\Models\Role>
 */
class RoleFactory extends Factory
{
    protected $model = \Mimachh\Guardians\Models\Role::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'slug' => $this->faker->slug,
        ];
    }
}
