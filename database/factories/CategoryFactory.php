<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(),
            'sort_order' => $this->faker->numberBetween(1, 100),
            'type' => $this->faker->randomElement(['channel', 'movie', 'series']),
            'is_active' => $this->faker->boolean(),
            'metadata' => [
                'icon' => $this->faker->word(),
                'color' => $this->faker->hexColor(),
            ],
        ];
    }
}