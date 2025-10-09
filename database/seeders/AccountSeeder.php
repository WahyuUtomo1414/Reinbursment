<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('account')->insert([
            [
                'type' => 'bank',
                'provider' => 'Bank BCA',
                'account_name' => 'Wahyu Dwi Utomo',
                'account_number' => '1234567890',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'bank',
                'provider' => 'Bank Mandiri',
                'account_name' => 'Wahyu Dwi Utomo',
                'account_number' => '9876543210',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'bank',
                'provider' => 'Bank BNI',
                'account_name' => 'Jason Purnomo',
                'account_number' => '1112223334',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'e-wallet',
                'provider' => 'OVO',
                'account_name' => 'Wahyu Dwi Utomo',
                'account_number' => '081234567890',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'e-wallet',
                'provider' => 'GoPay',
                'account_name' => 'Sukonto Legowo',
                'account_number' => '089876543210',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
