<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Employe;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected $model = User::class;

    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');

        $name = $faker->name();
        $emailBase = strtolower(str_replace(' ', '.', $name));

        return [
            'name' => $name,
            'email' => $faker->unique()->safeEmail() ?? "{$emailBase}@gmail.com",
            'password' => Hash::make('12345678'),
            'id_employe' => Employe::factory(),
            'active' => true,
        ];
    }
}
