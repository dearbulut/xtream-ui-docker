<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $superAdmin = Role::create(['name' => 'super-admin', 'guard_name' => 'web']);
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $user = Role::create(['name' => 'user', 'guard_name' => 'web']);

        // Create permissions
        $permissions = [
            'view_activity_logs',
            'export_activity_logs',
            'cleanup_activity_logs',
            'view_channels',
            'create_channels',
            'edit_channels',
            'delete_channels',
            'view_movies',
            'create_movies',
            'edit_movies',
            'delete_movies',
            'view_series',
            'create_series',
            'edit_series',
            'delete_series',
            'view_playlists',
            'create_playlists',
            'edit_playlists',
            'delete_playlists',
            'view_bouquets',
            'create_bouquets',
            'edit_bouquets',
            'delete_bouquets',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign permissions to roles
        $superAdmin->givePermissionTo(Permission::all());
        $admin->givePermissionTo([
            'view_activity_logs',
            'export_activity_logs',
            'cleanup_activity_logs',
            'view_channels',
            'view_movies',
            'view_series',
            'view_playlists',
            'view_bouquets',
        ]);
        $user->givePermissionTo([
            'view_channels',
            'view_movies',
            'view_series',
            'view_playlists',
            'view_bouquets',
        ]);
    }
}