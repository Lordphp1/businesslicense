<?php

namespace Tests\Feature;

use Database\Seeders\SiteContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The homepage renders successfully with seeded content.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $this->seed(SiteContentSeeder::class);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('A New Destination for Global Business and Investment.');
    }
}
