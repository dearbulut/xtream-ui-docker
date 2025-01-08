<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // Activity Logs
            'view_activity_logs',
            'export_activity_logs',
            'cleanup_activity_logs',

            // Channels
            'view_channels',
            'create_channels',
            'edit_channels',
            'delete_channels',

            // Movies
            'view_movies',
            'create_movies',
            'edit_movies',
            'delete_movies',

            // Series
            'view_series',
            'create_series',
            'edit_series',
            'delete_series',

            // Playlists
            'view_playlists',
            'create_playlists',
            'edit_playlists',
            'delete_playlists',

            // Bouquets
            'view_bouquets',
            'create_bouquets',
            'edit_bouquets',
            'delete_bouquets',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user = Role::firstOrCreate(['name' => 'user']);

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