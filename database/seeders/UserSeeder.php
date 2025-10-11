<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // === 1️⃣ Buat Positions ===
        $positions = [
            ['name' => 'Super Admin', 'description' => 'User with full access and control over the system.'],
            ['name' => 'Admin', 'description' => 'User responsible for managing and maintaining the system operations.'],
            ['name' => 'Staff', 'description' => 'Regular user who performs daily operational tasks within the company.'],
            ['name' => 'Manager', 'description' => 'User responsible for overseeing team performance and project execution.'],
            ['name' => 'Supervisor', 'description' => 'User who supervises and ensures smooth workflow within their department.'],
            ['name' => 'Lead', 'description' => 'User who leads a small team and coordinates work among team members.'],
            ['name' => 'Support', 'description' => 'User who provides technical or customer support to ensure smooth operations.'],
            ['name' => 'Legal', 'description' => 'User who handles legal documents, compliance, and corporate governance.'],
        ];

        foreach ($positions as $position) {
            DB::table('position')->updateOrInsert(
                ['name' => $position['name']],
                ['description' => $position['description']]
            );
        }

        // === 2️⃣ Buat Divisions ===
        $divisions = [
            ['name' => 'Finance', 'description' => 'Handles company financial operations and budgeting.', 'division_master' => null],
            ['name' => 'IT', 'description' => 'Responsible for information technology systems and support.', 'division_master' => null],
            ['name' => 'Business', 'description' => 'Focuses on business strategy, partnerships, and growth.', 'division_master' => null],
            ['name' => 'Marketing', 'description' => 'Manages branding, campaigns, and market research.', 'division_master' => null],
            ['name' => 'Master Division', 'description' => 'Responsible for overseeing all divisions.', 'division_master' => null],
        ];

        foreach ($divisions as $division) {
            DB::table('division')->updateOrInsert(
                ['name' => $division['name']],
                [
                    'description' => $division['description'],
                    'division_master' => $division['division_master'],
                ]
            );
        }

        // === 3️⃣ Buat Roles ===
        $roles = [
            'super-admin',
            'employee',
            'hrd',
            'finance',
            'division-master',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // === 4️⃣ Generate Permissions dari Policy Files ===
        $policyFiles = File::files(app_path('Policies'));
        $superAdminRole = Role::where('name', 'super-admin')->first();

        foreach ($policyFiles as $file) {
            $className = pathinfo($file, PATHINFO_FILENAME);
            $resource = strtolower(str_replace('Policy', '', $className));

            $actions = [
                'view_any', 'view', 'create', 'update', 'delete',
                'delete_any', 'force_delete', 'force_delete_any',
                'restore', 'restore_any', 'replicate', 'reorder',
            ];

            foreach ($actions as $action) {
                $permissionName = "{$action}_{$resource}";
                $permission = Permission::firstOrCreate(['name' => $permissionName]);
                $superAdminRole->givePermissionTo($permission);
            }
        }

        // === 5️⃣ Buat Employe + User ===
        $employees = [
            [
                'name' => 'Super Admin',
                'nik' => '0000000001',
                'id_position' => 1,
                'id_division' => 5, // Master Division
                'personal_number' => '081234567890',
                'user' => [
                    'name' => 'superadmin',
                    'email' => 'superadmin@gmail.com',
                    'password' => '12345678',
                    'role' => 'super-admin',
                ],
            ],
            [
                'name' => 'Employee',
                'nik' => '0000000003',
                'id_position' => 4,
                'id_division' => 2,
                'personal_number' => '081234567892',
                'user' => [
                    'name' => 'employee',
                    'email' => 'employee@gmail.com',
                    'password' => '12345678',
                    'role' => 'employee',
                ],
            ],
            [
                'name' => 'HRD',
                'nik' => '0000000004',
                'id_position' => 2,
                'id_division' => 3,
                'personal_number' => '081234567893',
                'user' => [
                    'name' => 'hrd',
                    'email' => 'hrd@gmail.com',
                    'password' => '12345678',
                    'role' => 'hrd',
                ],
            ],
            [
                'name' => 'Finance',
                'nik' => '0000000005',
                'id_position' => 3,
                'id_division' => 1,
                'personal_number' => '081234567894',
                'user' => [
                    'name' => 'finance',
                    'email' => 'finance@gmail.com',
                    'password' => '12345678',
                    'role' => 'finance',
                ],
            ],
            [
                'name' => 'Division Master',
                'nik' => '0000000006',
                'id_position' => 5,
                'id_division' => 5,
                'personal_number' => '081234567895',
                'user' => [
                    'name' => 'divisionmaster',
                    'email' => 'divisionmaster@gmail.com',
                    'password' => '12345678',
                    'role' => 'division-master',
                ],
            ],
        ];

        foreach ($employees as $emp) {
            $employeId = DB::table('employe')->insertGetId([
                'name' => $emp['name'],
                'nik' => $emp['nik'],
                'id_position' => $emp['id_position'],
                'id_division' => $emp['id_division'],
                'personal_number' => $emp['personal_number'],
                'active' => 1,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $user = User::create([
                'name' => $emp['user']['name'],
                'email' => $emp['user']['email'],
                'password' => Hash::make($emp['user']['password']),
                'id_employe' => $employeId,
                'active' => 1,
                'created_by' => 1,
            ]);

            $user->assignRole($emp['user']['role']);
        }

        // === 6️⃣ Update division_master Super Admin ===
        DB::table('division')->where('id', 5)->update([
            'division_master' => 1,
        ]);
    }
}
