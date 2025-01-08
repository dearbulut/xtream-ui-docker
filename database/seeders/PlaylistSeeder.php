<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlaylistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $playlists = [
            [
                'name' => 'Sports Package',
                'description' => 'All sports channels and content',
                'is_active' => true,
                'expires_at' => now()->addYear(),
                'max_connections' => 2,
                'allowed_ips' => ['192.168.1.1', '10.0.0.1'],
                'notes' => 'Premium sports package with all major sports channels',
                'categories' => ['Football', 'Basketball'],
                'bouquets' => ['Sports Package'],
            ],
            [
                'name' => 'Entertainment Bundle',
                'description' => 'Movies, series and entertainment channels',
                'is_active' => true,
                'expires_at' => now()->addMonths(6),
                'max_connections' => 1,
                'allowed_ips' => [],
                'notes' => 'Complete entertainment package with latest movies and series',
                'categories' => ['Music', 'Drama Series'],
                'bouquets' => ['Entertainment Package'],
            ],
            [
                'name' => 'News & Business',
                'description' => 'Stay updated with news and business channels',
                'is_active' => true,
                'expires_at' => now()->addMonths(3),
                'max_connections' => 1,
                'allowed_ips' => ['192.168.1.100'],
                'notes' => 'News and business channels from around the world',
                'categories' => ['International', 'Business'],
                'bouquets' => ['News Package'],
            ],
        ];

        $admin = \App\Models\Admin::first();

        foreach ($playlists as $playlist) {
            $categories = $playlist['categories'];
            $bouquetNames = $playlist['bouquets'];
            unset($playlist['categories'], $playlist['bouquets']);

            $newPlaylist = \App\Models\Playlist::create([
                ...$playlist,
                'username' => uniqid(),
                'password' => uniqid(),
            ]);

            // Bouquet'leri ekle
            $bouquets = \App\Models\Bouquet::whereIn('name', $bouquetNames)->get();
            $newPlaylist->bouquets()->attach($bouquets->pluck('id'));
        }
    }
}
