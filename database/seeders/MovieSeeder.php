<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movies = [
            [
                'name' => 'The Matrix',
                'stream_url' => 'http://example.com/movies/matrix',
                'logo' => 'https://example.com/logos/matrix.png',
                'category' => 'Action',
                'description' => 'A computer programmer discovers that reality as he knows it is a simulation created by machines.',
                'duration' => '2h 16m',
                'release_date' => '1999-03-31',
                'director' => 'Lana Wachowski, Lilly Wachowski',
                'cast' => 'Keanu Reeves, Laurence Fishburne, Carrie-Anne Moss',
                'genre' => 'Action, Sci-Fi',
                'rating' => '8.7',
                'poster' => 'https://example.com/posters/matrix.jpg',
                'backdrop' => 'https://example.com/backdrops/matrix.jpg',
                'trailer_url' => 'https://example.com/trailers/matrix.mp4',
            ],
            [
                'name' => 'Inception',
                'stream_url' => 'http://example.com/movies/inception',
                'logo' => 'https://example.com/logos/inception.png',
                'category' => 'Action',
                'description' => 'A thief who steals corporate secrets through the use of dream-sharing technology.',
                'duration' => '2h 28m',
                'release_date' => '2010-07-16',
                'director' => 'Christopher Nolan',
                'cast' => 'Leonardo DiCaprio, Joseph Gordon-Levitt, Ellen Page',
                'genre' => 'Action, Adventure, Sci-Fi',
                'rating' => '8.8',
                'poster' => 'https://example.com/posters/inception.jpg',
                'backdrop' => 'https://example.com/backdrops/inception.jpg',
                'trailer_url' => 'https://example.com/trailers/inception.mp4',
            ],
            [
                'name' => 'The Shawshank Redemption',
                'stream_url' => 'http://example.com/movies/shawshank',
                'logo' => 'https://example.com/logos/shawshank.png',
                'category' => 'Drama',
                'description' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
                'duration' => '2h 22m',
                'release_date' => '1994-09-23',
                'director' => 'Frank Darabont',
                'cast' => 'Tim Robbins, Morgan Freeman, Bob Gunton',
                'genre' => 'Drama',
                'rating' => '9.3',
                'poster' => 'https://example.com/posters/shawshank.jpg',
                'backdrop' => 'https://example.com/backdrops/shawshank.jpg',
                'trailer_url' => 'https://example.com/trailers/shawshank.mp4',
            ],
        ];

        foreach ($movies as $movie) {
            $category = \App\Models\Category::where('name', $movie['category'])->first();
            unset($movie['category']);

            if ($category) {
                $movie['category_id'] = $category->id;
                \App\Models\Movie::create($movie);
            }
        }
    }
}
