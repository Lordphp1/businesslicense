<?php

namespace Database\Factories;

use App\Models\Industry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Industry>
 */
class IndustryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'slug' => fake()->unique()->slug(2),
            'name' => fake()->unique()->words(2, true),
            'icon' => 'briefcase',
            'summary' => fake()->sentence(),
            'image_key' => 'sectors.agriculture',
            'is_priority' => fake()->boolean(60),
            'sort_order' => 0,
            'is_active' => true,
        ];
    }
}
