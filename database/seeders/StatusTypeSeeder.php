<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statusTypes = [
            ['name' => 'Default', 'description' => 'Status All'],
            ['name' => 'Payment', 'description' => 'Status For Payment'],
            ['name' => 'Reimbursement', 'description' => 'Status For Reimbursement'],
        ];

        foreach ($statusTypes as $type) {
            DB::table('status_type')->insert([
                'name' => $type['name'],
                'description' => $type['description'],
                'created_by' => 1,
            ]);
        }
    }
}
