<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $series = [
            [
                'name' => 'Breaking Bad',
                'logo' => 'https://example.com/logos/breaking-bad.png',
                'category' => 'Drama Series',
                'description' => 'A high school chemistry teacher turned methamphetamine manufacturer.',
                'release_date' => '2008-01-20',
                'director' => 'Vince Gilligan',
                'cast' => 'Bryan Cranston, Aaron Paul',
                'genre' => 'Crime, Drama, Thriller',
                'rating' => '9.5',
                'poster' => 'https://example.com/posters/breaking-bad.jpg',
                'backdrop' => 'https://example.com/backdrops/breaking-bad.jpg',
                'trailer_url' => 'https://example.com/trailers/breaking-bad.mp4',
                'seasons' => [
                    [
                        'name' => 'Season 1',
                        'season_number' => 1,
                        'description' => 'The first season of Breaking Bad.',
                        'poster' => 'https://example.com/posters/breaking-bad-s1.jpg',
                        'episodes' => [
                            [
                                'name' => 'Pilot',
                                'episode_number' => 1,
                                'stream_url' => 'http://example.com/series/breaking-bad/s01e01',
                                'description' => 'Walter White, a high school chemistry teacher, learns he has terminal cancer.',
                                'duration' => '58m',
                                'air_date' => '2008-01-20',
                            ],
                            [
                                'name' => 'Cat\'s in the Bag...',
                                'episode_number' => 2,
                                'stream_url' => 'http://example.com/series/breaking-bad/s01e02',
                                'description' => 'Walt and Jesse attempt to dispose of the bodies of two rivals.',
                                'duration' => '48m',
                                'air_date' => '2008-01-27',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Stranger Things',
                'logo' => 'https://example.com/logos/stranger-things.png',
                'category' => 'Drama Series',
                'description' => 'When a young boy disappears, his mother, a police chief and his friends must confront terrifying supernatural forces.',
                'release_date' => '2016-07-15',
                'director' => 'The Duffer Brothers',
                'cast' => 'Millie Bobby Brown, Finn Wolfhard',
                'genre' => 'Drama, Fantasy, Horror',
                'rating' => '8.7',
                'poster' => 'https://example.com/posters/stranger-things.jpg',
                'backdrop' => 'https://example.com/backdrops/stranger-things.jpg',
                'trailer_url' => 'https://example.com/trailers/stranger-things.mp4',
                'seasons' => [
                    [
                        'name' => 'Season 1',
                        'season_number' => 1,
                        'description' => 'The first season of Stranger Things.',
                        'poster' => 'https://example.com/posters/stranger-things-s1.jpg',
                        'episodes' => [
                            [
                                'name' => 'Chapter One: The Vanishing of Will Byers',
                                'episode_number' => 1,
                                'stream_url' => 'http://example.com/series/stranger-things/s01e01',
                                'description' => 'On his way home from a friend\'s house, young Will sees something terrifying.',
                                'duration' => '49m',
                                'air_date' => '2016-07-15',
                            ],
                            [
                                'name' => 'Chapter Two: The Weirdo on Maple Street',
                                'episode_number' => 2,
                                'stream_url' => 'http://example.com/series/stranger-things/s01e02',
                                'description' => 'Lucas, Mike and Dustin try to talk to the girl they found in the woods.',
                                'duration' => '56m',
                                'air_date' => '2016-07-15',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($series as $show) {
            $category = \App\Models\Category::where('name', $show['category'])->first();
            $seasons = $show['seasons'];
            unset($show['category'], $show['seasons']);

            if ($category) {
                $show['category_id'] = $category->id;
                $series = \App\Models\Series::create($show);

                foreach ($seasons as $season) {
                    $episodes = $season['episodes'];
                    unset($season['episodes']);

                    $season = $series->seasons()->create($season);

                    foreach ($episodes as $episode) {
                        $season->episodes()->create($episode);
                    }
                }
            }
        }
    }
}
