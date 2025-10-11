<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('division')->insert([
            [
                'division_master' => null,
                'name' => 'Finance',
                'description' => 'Handles company financial operations and budgeting.',
            ],
            [
                'division_master' => null,
                'name' => 'IT',
                'description' => 'Responsible for information technology systems and support.',
            ],
            [
                'division_master' => null,
                'name' => 'Business',
                'description' => 'Focuses on business strategy, partnerships, and growth.',
            ],
            [
                
                'name' => 'Marketing',
                'description' => 'Manages branding, campaigns, and market research.',
            ],
        ]);
    }
}
