<?php

namespace Database\Factories;

use App\Models\Playlist;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaylistFactory extends Factory
{
    protected $model = Playlist::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'username' => $this->faker->userName,
            'password' => $this->faker->password,
            'is_active' => true,
            'is_trial' => false,
            'expires_at' => null,
            'max_connections' => 1,
            'active_connections' => 0,
        ];
    }
}