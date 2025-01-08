<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            AdminSeeder::class,
            CategorySeeder::class,
            ChannelSeeder::class,
            EpgProgramSeeder::class,
            MovieSeeder::class,
            SeriesSeeder::class,
            BouquetSeeder::class,
            PlaylistSeeder::class,
            ActivityLogSeeder::class,
        ]);
    }
}
