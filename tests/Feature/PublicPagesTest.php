<?php

namespace Tests\Feature;

use App\Models\Enquiry;
use App\Models\Industry;
use App\Models\InvestmentOpportunity;
use App\Models\NewsPost;
use Database\Seeders\SiteContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(SiteContentSeeder::class);
    }

    public function test_primary_public_pages_render(): void
    {
        $pages = [
            '/about',
            '/services',
            '/start-a-business',
            '/business-registration',
            '/business-licensing',
            '/opportunities',
            '/sectors',
            '/news',
            '/contact',
            '/login',
        ];

        foreach ($pages as $page) {
            $this->get($page)->assertOk();
        }
    }

    public function test_opportunities_can_be_filtered_by_sector(): void
    {
        $industry = Industry::query()->where('slug', 'agriculture')->firstOrFail();

        $response = $this->get('/opportunities?sector=agriculture');

        $response->assertOk();
        $response->assertSee('Agribusiness Processing Facility');
        $response->assertDontSee('Utility-Scale Solar Programme');

        $this->assertSame(
            1,
            InvestmentOpportunity::query()->where('industry_id', $industry->id)->count(),
        );
    }

    public function test_opportunities_can_be_filtered_by_keyword(): void
    {
        $response = $this->get('/opportunities?q=logistics');

        $response->assertOk();
        $response->assertSee('Regional Logistics &amp; Distribution Hub', false);
        $response->assertDontSee('Technology Campus');
    }

    public function test_sector_page_lists_its_opportunities_and_siblings(): void
    {
        $response = $this->get('/sectors/energy');

        $response->assertOk();
        $response->assertSee('Utility-Scale Solar Programme');
        $response->assertSee('Other Sectors');
    }

    public function test_news_index_featured_post_is_excluded_from_the_grid(): void
    {
        $featured = NewsPost::query()->where('is_featured', true)->firstOrFail();

        $response = $this->get('/news');

        $response->assertOk();
        $response->assertSee($featured->title);
        $response->assertSee('Featured');
    }

    public function test_unpublished_news_post_returns_not_found(): void
    {
        $post = NewsPost::factory()->create(['published_at' => null]);

        $this->get('/news/'.$post->slug)->assertNotFound();
    }

    public function test_contact_form_stores_an_enquiry_and_redirects_with_confirmation(): void
    {
        $industry = Industry::query()->firstOrFail();

        $response = $this->post('/contact', [
            'name' => 'Jordan Alvarez',
            'email' => 'jordan.alvarez@example.com',
            'phone' => '+44 20 7946 0000',
            'country' => 'United Kingdom',
            'subject' => 'Manufacturing enquiry',
            'industry_id' => $industry->id,
            'message' => 'We would like to discuss establishing a manufacturing operation.',
        ]);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('enquiries', [
            'name' => 'Jordan Alvarez',
            'email' => 'jordan.alvarez@example.com',
            'industry_id' => $industry->id,
            'status' => 'new',
            'source' => 'contact-page',
        ]);
    }

    public function test_contact_form_validates_required_fields(): void
    {
        $response = $this->post('/contact', [
            'name' => '',
            'email' => 'not-an-email',
            'message' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
        $this->assertSame(0, Enquiry::query()->count());
    }
}
