<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $channels = [
            // Spor kanalları
            [
                'name' => 'beIN Sports 1',
                'stream_url' => 'http://example.com/bein1',
            'source' => 'http://example.com/bein1',
                'logo' => 'https://example.com/logos/bein1.png',
                'category' => 'Football',
                'stream_type' => 'live',
            ],
            [
                'name' => 'beIN Sports 2',
                'stream_url' => 'http://example.com/bein2',
                'source' => 'http://example.com/bein2',
                'logo' => 'https://example.com/logos/bein2.png',
                'category' => 'Football',
                'stream_type' => 'live',
            ],
            [
                'name' => 'NBA TV',
                'stream_url' => 'http://example.com/nba',
                'source' => 'http://example.com/nba',
                'logo' => 'https://example.com/logos/nba.png',
                'category' => 'Basketball',
                'stream_type' => 'live',
            ],

            // Haber kanalları
            [
                'name' => 'CNN International',
                'stream_url' => 'http://example.com/cnn',
                'source' => 'http://example.com/cnn',
                'logo' => 'https://example.com/logos/cnn.png',
                'category' => 'International',
                'stream_type' => 'live',
            ],
            [
                'name' => 'BBC World News',
                'stream_url' => 'http://example.com/bbc',
                'source' => 'http://example.com/bbc',
                'logo' => 'https://example.com/logos/bbc.png',
                'category' => 'International',
                'stream_type' => 'live',
            ],
            [
                'name' => 'Bloomberg',
                'stream_url' => 'http://example.com/bloomberg',
                'source' => 'http://example.com/bloomberg',
                'logo' => 'https://example.com/logos/bloomberg.png',
                'category' => 'Business',
                'stream_type' => 'live',
            ],

            // Eğlence kanalları
            [
                'name' => 'MTV',
                'stream_url' => 'http://example.com/mtv',
                'source' => 'http://example.com/mtv',
                'logo' => 'https://example.com/logos/mtv.png',
                'category' => 'Music',
                'stream_type' => 'live',
            ],
            [
                'name' => 'VH1',
                'stream_url' => 'http://example.com/vh1',
                'source' => 'http://example.com/vh1',
                'logo' => 'https://example.com/logos/vh1.png',
                'category' => 'Music',
                'stream_type' => 'live',
            ],
        ];

        foreach ($channels as $channel) {
            $category = \App\Models\Category::where('name', $channel['category'])->first();
            unset($channel['category']);

            if ($category) {
                $channel['category_id'] = $category->id;
                \App\Models\Channel::create($channel);
            }
        }
    }
}
