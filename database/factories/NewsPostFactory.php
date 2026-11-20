<?php

namespace Database\Factories;

use App\Models\NewsPost;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NewsPost>
 */
class NewsPostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'slug' => fake()->unique()->slug(3),
            'title' => fake()->unique()->sentence(6),
            'excerpt' => fake()->sentence(),
            'body' => fake()->paragraphs(3, true),
            'category' => fake()->randomElement(['news', 'press-release', 'publication']),
            'image_key' => 'news.newspaper',
            'is_featured' => false,
            'published_at' => fake()->dateTimeBetween('-2 months', 'now'),
        ];
    }
}
