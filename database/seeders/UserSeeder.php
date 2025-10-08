<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            [
                'name' => 'Super Admin',
                'nik' => '0000000001',
                'id_position' => 1,
                'personal_number' => '081234567890',
                'user' => [
                    'name' => 'superadmin',
                    'email' => 'superadmin@gmail.com',
                    'password' => '12345678',
                ],
            ],
            [
                'name' => 'Admin IT',
                'nik' => '0000000002',
                'id_position' => 5,
                'personal_number' => '081234567891',
                'user' => [
                    'name' => 'adminit',
                    'email' => 'adminit@gmail.com',
                    'password' => '12345678',
                ],
            ],
            [
                'name' => 'Employee',
                'nik' => '0000000003',
                'id_position' => 4,
                'personal_number' => '081234567892',
                'user' => [
                    'name' => 'employee',
                    'email' => 'employee@gmail.com',
                    'password' => '12345678',
                ],
            ],
            [
                'name' => 'HRD',
                'nik' => '0000000004',
                'id_position' => 2,
                'personal_number' => '081234567893',
                'user' => [
                    'name' => 'hrd',
                    'email' => 'hrd@gmail.com',
                    'password' => '12345678',
                ],
            ],
            [
                'name' => 'Finance',
                'nik' => '0000000005',
                'id_position' => 3,
                'personal_number' => '081234567894',
                'user' => [
                    'name' => 'finance',
                    'email' => 'finance@gmail.com',
                    'password' => '12345678',
                ],
            ],
        ];

        foreach ($employees as $emp) {
            // buat data employe
            $employeId = DB::table('employe')->insertGetId([
                'name' => $emp['name'],
                'nik' => $emp['nik'],
                'id_position' => $emp['id_position'],
                'personal_number' => $emp['personal_number'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // buat user terkait
            DB::table('users')->insert([
                'name' => $emp['user']['name'],
                'email' => $emp['user']['email'],
                'password' => Hash::make($emp['user']['password']),
                'id_employe' => $employeId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
