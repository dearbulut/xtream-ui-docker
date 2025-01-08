<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BouquetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bouquets = [
            [
                'name' => 'Sports Package',
                'description' => 'All sports channels in one package',
                'type' => 'channel',
                'is_active' => true,
                'sort_order' => 1,
                'categories' => ['Football', 'Basketball'],
            ],
            [
                'name' => 'News Package',
                'description' => 'Stay updated with news channels',
                'type' => 'channel',
                'is_active' => true,
                'sort_order' => 2,
                'categories' => ['International', 'Business'],
            ],
            [
                'name' => 'Entertainment Package',
                'description' => 'Best entertainment channels',
                'type' => 'channel',
                'is_active' => true,
                'sort_order' => 3,
                'categories' => ['Music'],
            ],
        ];

        foreach ($bouquets as $bouquet) {
            $categories = $bouquet['categories'];
            unset($bouquet['categories']);

            $newBouquet = \App\Models\Bouquet::create($bouquet);

            // Kategorilere göre kanalları ekle
            $channels = \App\Models\Channel::whereHas('category', function ($query) use ($categories) {
                $query->whereIn('name', $categories);
            })->get();

            $newBouquet->channels()->attach($channels->pluck('id'));
        }
    }
}
