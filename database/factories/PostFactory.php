<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'title' => fake()->sentence(6),
            'excerpt' => fake()->paragraph(),
            'body' => fake()->paragraphs(6, true),
            'is_published' => fake()->boolean(85),
        ];
    }
}