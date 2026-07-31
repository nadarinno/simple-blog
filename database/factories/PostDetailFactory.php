<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\PostDetail>
 */
class PostDetailFactory extends Factory
{
    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'reading_minutes' => fake()->numberBetween(1, 12),
            'source' => fake()->optional()->url(),
        ];
    }
}