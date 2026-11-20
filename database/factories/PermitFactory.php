<?php

namespace Database\Factories;

use App\Models\Permit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Permit>
 */
class PermitFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'name' => Str::title($name),
            'slug' => Str::slug($name),
            'authority' => fake()->optional()->company(),
            'summary' => fake()->sentence(12),
            'fee' => fake()->optional(0.6)->randomFloat(2, 50, 1500),
            'currency' => 'USD',
            'turnaround' => fake()->optional(0.5)->randomElement(['3–5 working days', '5–10 working days', 'Confirmed on assessment']),
            'sort_order' => 0,
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => ['is_active' => false]);
    }
}
