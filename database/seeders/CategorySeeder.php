<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('category')->insert([
            [
                'name' => 'Transportation',
                'description' => 'Covers transportation expenses such as fuel, tolls, parking fees, or public transport during business trips.',
                'limit' => 500000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Meals and Drinks',
                'description' => 'Covers meal and beverage costs during business activities or overtime work.',
                'limit' => 300000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Accommodation',
                'description' => 'Includes hotel or lodging expenses during official business trips.',
                'limit' => 1500000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Health',
                'description' => 'Covers medical expenses such as medication, doctor consultation, or health check-ups.',
                'limit' => 1000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Office Supplies',
                'description' => 'Covers expenses for office materials like stationery, printer ink, or other work-related supplies.',
                'limit' => 750000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Training and Seminar',
                'description' => 'Covers registration fees for employee training, seminars, or workshops.',
                'limit' => 2000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Communication',
                'description' => 'Includes reimbursement for phone credit, internet data, or communication tools used for work purposes.',
                'limit' => 250000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Representation',
                'description' => 'Covers expenses related to client meetings, entertainment, or external company relations.',
                'limit' => 1000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Project Expense',
                'description' => 'Covers expenses directly related to specific company projects or assignments.',
                'limit' => 3000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Miscellaneous',
                'description' => 'General category for reimbursement claims that do not fall under any other category.',
                'limit' => 500000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
