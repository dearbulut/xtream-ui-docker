<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Kanal kategorileri
            [
                'name' => 'Sports',
                'type' => 'channel',
                'children' => [
                    ['name' => 'Football', 'type' => 'channel'],
                    ['name' => 'Basketball', 'type' => 'channel'],
                    ['name' => 'Tennis', 'type' => 'channel'],
                ],
            ],
            [
                'name' => 'News',
                'type' => 'channel',
                'children' => [
                    ['name' => 'International', 'type' => 'channel'],
                    ['name' => 'Local', 'type' => 'channel'],
                    ['name' => 'Business', 'type' => 'channel'],
                ],
            ],
            [
                'name' => 'Entertainment',
                'type' => 'channel',
                'children' => [
                    ['name' => 'Music', 'type' => 'channel'],
                    ['name' => 'Reality Shows', 'type' => 'channel'],
                    ['name' => 'Game Shows', 'type' => 'channel'],
                ],
            ],

            // Film kategorileri
            [
                'name' => 'Movies',
                'type' => 'movie',
                'children' => [
                    ['name' => 'Action', 'type' => 'movie'],
                    ['name' => 'Comedy', 'type' => 'movie'],
                    ['name' => 'Drama', 'type' => 'movie'],
                    ['name' => 'Horror', 'type' => 'movie'],
                    ['name' => 'Sci-Fi', 'type' => 'movie'],
                ],
            ],

            // Dizi kategorileri
            [
                'name' => 'TV Series',
                'type' => 'series',
                'children' => [
                    ['name' => 'Action Series', 'type' => 'series'],
                    ['name' => 'Comedy Series', 'type' => 'series'],
                    ['name' => 'Drama Series', 'type' => 'series'],
                    ['name' => 'Crime Series', 'type' => 'series'],
                    ['name' => 'Documentary Series', 'type' => 'series'],
                ],
            ],
        ];

        foreach ($categories as $category) {
            $children = $category['children'] ?? [];
            unset($category['children']);

            $parent = \App\Models\Category::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($category['name'])],
                [
                'name' => $category['name'],
                'slug' => \Illuminate\Support\Str::slug($category['name']),
                'type' => $category['type'],
                'is_active' => true,
            ]);

            foreach ($children as $child) {
                \App\Models\Category::firstOrCreate(
                    ['slug' => \Illuminate\Support\Str::slug($child['name'])],
                    [
                    'name' => $child['name'],
                    'slug' => \Illuminate\Support\Str::slug($child['name']),
                    'type' => $child['type'],
                    'parent_id' => $parent->id,
                    'is_active' => true,
                ]);
            }
        }
    }
}
