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
                'description' => 'User dengan akses penuh ke sistem',
            ],
            [
                'name' => 'HRD',
                'description' => 'User yang bertanggung jawab atas manajemen sumber daya manusia',
            ],
            [
                'name' => 'Finance',
                'description' => 'User yang menangani keuangan perusahaan',
            ],
            [
                'name' => 'Employee',
                'description' => 'User biasa dengan akses terbatas',
            ],
            [
                'name' => 'Admin IT',
                'description' => 'User yang mengelola sistem dan infrastruktur IT',
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
