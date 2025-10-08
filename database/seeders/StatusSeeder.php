<?php

namespace Database\Seeders;

use App\Models\StatusType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'Default' => ['Active', 'Non Active', 'Draft'],
            'Payment' => ['Pending', 'Success', 'Failed'],
            'Reimbursement' => ['Pending', 'Approve', 'Reject'],
        ];

        foreach ($statuses as $typeName => $statusNames) {
            // Ambil StatusType ID
            $type = StatusType::where('name', $typeName)->first();

            foreach ($statusNames as $statusName) {
                DB::table('status')->insert([
                    'name' => $statusName,
                    'status_type_id' => $type->id,
                    'created_by' => 1,
                ]);
            }
        }
    }
}
