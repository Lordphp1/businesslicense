<?php

namespace Database\Factories;

use App\Models\Industry;
use App\Models\InvestmentOpportunity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InvestmentOpportunity>
 */
class InvestmentOpportunityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'slug' => fake()->unique()->slug(3),
            'title' => fake()->unique()->sentence(4),
            'summary' => fake()->paragraph(),
            'industry_id' => Industry::factory(),
            'location' => 'Region to be confirmed',
            'investment_min' => 'Provisional — to be confirmed',
            'investment_max' => null,
            'status' => 'published',
            'is_featured' => false,
            'image_key' => 'opportunities.city',
            'sort_order' => 0,
        ];
    }
}
