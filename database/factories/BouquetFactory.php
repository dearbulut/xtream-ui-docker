<?php

namespace Database\Factories;

use App\Models\Bouquet;
use Illuminate\Database\Eloquent\Factories\Factory;

class BouquetFactory extends Factory
{
    protected $model = Bouquet::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'type' => $this->faker->randomElement(['all', 'channel', 'movie', 'series']),
        ];
    }
}