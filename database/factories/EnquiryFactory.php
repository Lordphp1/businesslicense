<?php

namespace Database\Factories;

use App\Models\Enquiry;
use App\Models\Industry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Enquiry>
 */
class EnquiryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->optional()->phoneNumber(),
            'country' => fake()->optional()->country(),
            'subject' => fake()->optional()->sentence(4),
            'industry_id' => Industry::factory(),
            'message' => fake()->paragraph(),
            'status' => 'new',
            'source' => 'contact-page',
        ];
    }
}
