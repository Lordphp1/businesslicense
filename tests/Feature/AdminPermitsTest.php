<?php

namespace Tests\Feature;

use App\Models\Permit;
use App\Models\User;
use Database\Seeders\SiteContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPermitsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(SiteContentSeeder::class);
    }

    public function test_guests_are_redirected_and_investors_are_forbidden(): void
    {
        $this->get('/admin/permits')->assertRedirect(route('login'));
        $this->get('/admin/permits/create')->assertRedirect(route('login'));

        $investor = User::factory()->create();
        $permit = Permit::query()->firstOrFail();

        $this->actingAs($investor)->get('/admin/permits')->assertForbidden();
        $this->actingAs($investor)->get('/admin/permits/create')->assertForbidden();
        $this->actingAs($investor)->get("/admin/permits/{$permit->id}/edit")->assertForbidden();
        $this->actingAs($investor)
            ->post('/admin/permits', [
                'name' => 'Not allowed',
                'currency' => 'USD',
            ])
            ->assertForbidden();
        $this->actingAs($investor)
            ->put("/admin/permits/{$permit->id}", [
                'name' => 'Not allowed either',
                'currency' => 'USD',
            ])
            ->assertForbidden();
    }

    public function test_staff_see_the_seeded_permit_catalogue(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/admin/permits');

        $response->assertOk();
        $response->assertSee('General Business License');
        $response->assertSee('Employer Identification Number (EIN)');
        $response->assertSee('Doing Business As (DBA)');
        $response->assertSee('Federal Permits');
        $response->assertSee('Sales Tax Permit');
        $response->assertSee('On assessment');
    }

    public function test_staff_can_add_a_permit_with_pricing_and_it_appears_publicly(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post('/admin/permits', [
            'name' => 'Environmental Impact Permit',
            'slug' => '',
            'authority' => 'State environmental agency',
            'summary' => 'Authorisation required before certain works disturb the site.',
            'fee' => '1250.50',
            'currency' => 'usd',
            'turnaround' => '10–15 working days',
            'sort_order' => '9',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.permits.index'));
        $response->assertSessionHas('success');

        $permit = Permit::query()->where('slug', 'environmental-impact-permit')->firstOrFail();

        $this->assertSame('Environmental Impact Permit', $permit->name);
        $this->assertSame('State environmental agency', $permit->authority);
        $this->assertSame('USD', $permit->currency);
        $this->assertSame('1250.50', $permit->fee);
        $this->assertSame(9, $permit->sort_order);
        $this->assertTrue($permit->is_active);

        $this->get('/business-licensing')
            ->assertOk()
            ->assertSee('Environmental Impact Permit')
            ->assertSee('$1,250.50')
            ->assertSee('State environmental agency');
    }

    public function test_a_permit_requires_a_name_and_valid_pricing(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('/admin/permits', [
                'name' => '',
                'fee' => 'not-a-number',
                'currency' => 'US',
            ])
            ->assertSessionHasErrors(['name', 'fee', 'currency']);

        $this->assertDatabaseCount('permits', 5);
    }

    public function test_a_generated_slug_must_not_collide_with_an_existing_permit(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('/admin/permits', [
                'name' => 'General Business License',
                'slug' => '',
                'fee' => '100',
                'currency' => 'USD',
            ])
            ->assertSessionHasErrors('slug');

        $this->assertDatabaseCount('permits', 5);
    }

    public function test_staff_can_change_pricing_and_hide_a_permit_from_the_public_page(): void
    {
        $admin = User::factory()->admin()->create();
        $permit = Permit::query()->where('slug', 'doing-business-as')->firstOrFail();

        $this->actingAs($admin)
            ->put("/admin/permits/{$permit->id}", [
                'name' => $permit->name,
                'slug' => $permit->slug,
                'authority' => $permit->authority,
                'summary' => $permit->summary,
                'fee' => '350',
                'currency' => 'USD',
                'turnaround' => '5–7 working days',
                'sort_order' => '3',
            ])
            ->assertRedirect(route('admin.permits.index'));

        $permit->refresh();

        $this->assertSame('350.00', $permit->fee);
        $this->assertFalse($permit->is_active);

        $this->get('/business-licensing')
            ->assertOk()
            ->assertDontSee('Doing Business As (DBA)');

        $this->actingAs($admin)
            ->put("/admin/permits/{$permit->id}", [
                'name' => $permit->name,
                'slug' => $permit->slug,
                'fee' => '',
                'currency' => 'USD',
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.permits.index'));

        $permit->refresh();

        $this->assertNull($permit->fee);
        $this->assertTrue($permit->is_active);

        $this->get('/business-licensing')
            ->assertOk()
            ->assertSee('Doing Business As (DBA)')
            ->assertSee('On assessment');
    }

    public function test_the_public_page_lists_only_published_permits(): void
    {
        $hidden = Permit::factory()->inactive()->create(['name' => 'Archived Dock Permit']);
        $published = Permit::factory()->create([
            'name' => 'Customs Bonded Warehouse Permit',
            'fee' => 900,
            'currency' => 'USD',
        ]);

        $response = $this->get('/business-licensing');

        $response->assertOk();
        $response->assertSee($published->name);
        $response->assertSee('$900');
        $response->assertDontSee($hidden->name);
    }

    public function test_staff_can_open_the_edit_form_with_current_pricing(): void
    {
        $admin = User::factory()->admin()->create();

        $permit = Permit::factory()->create([
            'name' => 'Signage Consent',
            'fee' => 175,
            'currency' => 'GBP',
        ]);

        $response = $this->actingAs($admin)->get("/admin/permits/{$permit->id}/edit");

        $response->assertOk();
        $response->assertSee('Signage Consent');
        $response->assertSee('175.00');
        $response->assertSee('GBP');
    }
}
