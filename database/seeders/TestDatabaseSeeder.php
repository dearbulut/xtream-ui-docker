<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class TestDatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            'view_activity_logs',
            'cleanup_activity_logs',
            'export_activity_logs',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);

        // Assign permissions to roles
        $adminRole->givePermissionTo($permissions);
        $superAdminRole->givePermissionTo(Permission::all());
    }
}