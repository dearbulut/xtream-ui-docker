<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Admin::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
            'username' => 'admin',
            'password' => bcrypt('admin123'),
            'email' => 'admin@example.com',
            'name' => 'Administrator',
            'is_active' => true,
            'permissions' => ['*'],
        ])
            ->assignRole('super-admin');
    }
}
