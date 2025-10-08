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
        // Buat data employe
        $employeId = DB::table('employe')->insertGetId([
            'name' => 'Administrator',
            'nik' => '0000000001',
            'id_position' => 1,
            'personal_number' => '1234567890',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Buat user super admin
        DB::table('users')->insert([
            'name' => 'superadmin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'id_employe' => $employeId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
