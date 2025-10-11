<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            [
                'name' => 'Super Admin',
                'description' => 'User with full access and control over the system.',
            ],
            [
                'name' => 'Admin',
                'description' => 'User responsible for managing and maintaining the system operations.',
            ],
            [
                'name' => 'Staff',
                'description' => 'Regular user who performs daily operational tasks within the company.',
            ],
            [
                'name' => 'Manager',
                'description' => 'User responsible for overseeing team performance and project execution.',
            ],
            [
                'name' => 'Supervisor',
                'description' => 'User who supervises and ensures smooth workflow within their department.',
            ],
            [
                'name' => 'Lead',
                'description' => 'User who leads a small team and coordinates work among team members.',
            ],
            [
                'name' => 'Support',
                'description' => 'User who provides technical or customer support to ensure smooth operations.',
            ],
            [
                'name' => 'Legal',
                'description' => 'User who handles legal documents, compliance, and corporate governance.',
            ],
        ];

        foreach ($positions as $position) {
            DB::table('position')->insert([
                'name' => $position['name'],
                'description' => $position['description'],
            ]);
        }

    }
}
