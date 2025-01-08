<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChannelFactory extends Factory
{
    protected $model = Channel::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'stream_url' => $this->faker->url(),
            'logo' => $this->faker->imageUrl(),
            'epg_channel_id' => $this->faker->uuid(),
            'is_active' => $this->faker->boolean(),
            'category_id' => Category::factory(),
            'sort_order' => $this->faker->numberBetween(1, 1000),
            'metadata' => [
                'language' => $this->faker->languageCode(),
                'country' => $this->faker->countryCode(),
                'quality' => $this->faker->randomElement(['SD', 'HD', '4K']),
            ],
        ];
    }
}