<?php

namespace Database\Factories;

use App\Models\Employe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employe>
 */
class EmployeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Employe::class;

    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID'); // faker Indonesia

        return [
            'name' => $faker->name(),
            'nik' => $faker->unique()->numerify('###############'), // 15 digit angka
            'personal_number' => $faker->unique()->numerify('PN-########'),
            'id_position' => \App\Models\Position::inRandomOrder()->value('id') ?? \App\Models\Position::factory(),
            'id_division' => \App\Models\Division::inRandomOrder()->value('id') ?? \App\Models\Division::factory(),
            'active' => true,
            'created_at' => now(),
        ];
    }
}
