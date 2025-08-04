<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $roles = ['super_admin', 'admin', 'finance'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Optional: create dummy permissions (for dev/testing)
        if (Permission::count() === 0) {
            $defaultPermissions = [
                'view_any_user',
                'view_user',
                'create_user',
                'update_user',
                'delete_user',
                'delete_any_user',
                'force_delete_user',
                'force_delete_any_user',
                'restore_user',
                'restore_any_user',
                'replicate_user',
                'reorder_user',
                'view_any_role',
                'view_role',
                'create_role',
                'update_role',
                'delete_role',
                'delete_any_role',
            ];

            foreach ($defaultPermissions as $permission) {
                Permission::firstOrCreate(['name' => $permission]);
            }
        }

        // Assign all permissions to super_admin
        $superAdminRole = Role::where('name', 'super_admin')->first();
        $superAdminRole->syncPermissions(Permission::all());

        // Assign only user-related permissions to admin
        $adminRole = Role::where('name', 'admin')->first();
        $adminPermissions = [
            'view_any_user',
            'view_user',
            'create_user',
            'update_user',
            'delete_user',
            'delete_any_user',
            'force_delete_user',
            'force_delete_any_user',
            'restore_user',
            'restore_any_user',
            'replicate_user',
            'reorder_user',
        ];
        $adminRole->syncPermissions($adminPermissions);
        
        // Create users
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'super_admin@test.com',
                'role' => 'super_admin',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@test.com',
                'role' => 'admin',
            ],
            [
                'name' => 'Finance',
                'email' => 'finance@test.com',
                'role' => 'finance',
            ],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                ]
            );

            $user->assignRole($data['role']);
        }
    }
}
