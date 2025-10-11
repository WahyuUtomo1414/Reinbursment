<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //\App\Models\User::factory(50)->create();

        $this->call([
            //PositionSeeder::class,
            //DivisionSeeder::class,
            //RoleSeeder::class,
            UserSeeder::class,
            StatusTypeSeeder::class,
            StatusSeeder::class,
            AccountSeeder::class,
            CategorySeeder::class,
    ]);
    }
}
