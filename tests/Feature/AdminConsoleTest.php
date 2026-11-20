<?php

namespace Tests\Feature;

use App\Models\Enquiry;
use App\Models\User;
use Database\Seeders\SiteContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminConsoleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(SiteContentSeeder::class);
    }

    public function test_guests_are_redirected_and_investors_are_forbidden(): void
    {
        $this->get('/admin')->assertRedirect(route('login'));

        $investor = User::factory()->create();

        $this->actingAs($investor)->get('/admin')->assertForbidden();
        $this->actingAs($investor)->get('/admin/enquiries')->assertForbidden();
    }

    public function test_a_staff_account_sees_the_pipeline_overview(): void
    {
        $admin = User::factory()->admin()->create();

        Enquiry::factory()->count(2)->create(['status' => 'new']);
        Enquiry::factory()->create(['status' => 'closed', 'handled_at' => now()]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertOk();
        $response->assertSee('Pipeline overview');
        $response->assertSee('Needs an owner');
        $response->assertSee('Latest enquiries');
    }

    public function test_the_queue_lists_every_enquiry_including_other_investors(): void
    {
        $admin = User::factory()->admin()->create();
        $investor = User::factory()->create();

        Enquiry::factory()->create([
            'user_id' => $investor->id,
            'name' => 'Linked Investor',
            'subject' => 'Linked account enquiry',
        ]);

        Enquiry::factory()->create([
            'user_id' => null,
            'name' => 'Anonymous Visitor',
            'subject' => 'Visitor enquiry',
        ]);

        $response = $this->actingAs($admin)->get('/admin/enquiries');

        $response->assertOk();
        $response->assertSee('Linked account enquiry');
        $response->assertSee('Visitor enquiry');
        $response->assertSee('Linked Investor');
    }

    public function test_the_queue_can_be_filtered_by_status_ownership_and_keyword(): void
    {
        $admin = User::factory()->admin()->create();

        $mine = Enquiry::factory()->create([
            'status' => 'assigned',
            'assigned_to' => $admin->id,
            'subject' => 'Mine to handle',
        ]);

        Enquiry::factory()->create([
            'status' => 'new',
            'assigned_to' => null,
            'subject' => 'Unclaimed request',
        ]);

        Enquiry::factory()->create([
            'status' => 'closed',
            'subject' => 'Archived matter',
            'assigned_to' => $admin->id,
            'handled_at' => now(),
        ]);

        $this->actingAs($admin)
            ->get('/admin/enquiries?status=closed')
            ->assertSee('Archived matter')
            ->assertDontSee('Unclaimed request');

        $this->actingAs($admin)
            ->get('/admin/enquiries?assignment=unassigned')
            ->assertSee('Unclaimed request')
            ->assertDontSee('Archived matter');

        $this->actingAs($admin)
            ->get('/admin/enquiries?assignment=mine')
            ->assertSee('Mine to handle')
            ->assertSee('Archived matter')
            ->assertDontSee('Unclaimed request');

        $this->actingAs($admin)
            ->get('/admin/enquiries?q=Archived')
            ->assertSee('Archived matter')
            ->assertDontSee('Mine to handle');

        $this->assertSame($admin->id, $mine->assigned_to);
    }

    public function test_an_enquiry_cannot_be_marked_assigned_without_an_owner(): void
    {
        $admin = User::factory()->admin()->create();
        $enquiry = Enquiry::factory()->create(['status' => 'new']);

        $this->actingAs($admin)
            ->put("/admin/enquiries/{$enquiry->id}", [
                'status' => 'assigned',
                'assigned_to' => '',
            ])
            ->assertSessionHasErrors('assigned_to');

        $this->assertSame('new', $enquiry->refresh()->status);
    }

    public function test_an_enquiry_can_be_assigned_and_closed(): void
    {
        $admin = User::factory()->admin()->create();
        $enquiry = Enquiry::factory()->create(['status' => 'new']);

        $this->actingAs($admin)
            ->put("/admin/enquiries/{$enquiry->id}", [
                'status' => 'assigned',
                'assigned_to' => $admin->id,
            ])
            ->assertRedirect(route('admin.enquiries.show', $enquiry));

        $enquiry->refresh();

        $this->assertSame('assigned', $enquiry->status);
        $this->assertSame($admin->id, $enquiry->assigned_to);
        $this->assertNull($enquiry->handled_at);

        $this->actingAs($admin)
            ->put("/admin/enquiries/{$enquiry->id}", [
                'status' => 'closed',
                'assigned_to' => $admin->id,
            ])
            ->assertRedirect(route('admin.enquiries.show', $enquiry));

        $enquiry->refresh();

        $this->assertSame('closed', $enquiry->status);
        $this->assertNotNull($enquiry->handled_at);

        $this->actingAs($admin)
            ->put("/admin/enquiries/{$enquiry->id}", [
                'status' => 'new',
                'assigned_to' => '',
            ]);

        $this->assertNull($enquiry->refresh()->handled_at);
    }

    public function test_internal_notes_are_recorded_with_their_author(): void
    {
        $admin = User::factory()->admin()->create();
        $enquiry = Enquiry::factory()->create();

        $this->actingAs($admin)
            ->post("/admin/enquiries/{$enquiry->id}/notes", [
                'body' => 'Called the investor; documents expected next week.',
            ])
            ->assertRedirect(route('admin.enquiries.show', $enquiry));

        $this->assertDatabaseHas('enquiry_notes', [
            'enquiry_id' => $enquiry->id,
            'user_id' => $admin->id,
            'body' => 'Called the investor; documents expected next week.',
        ]);

        $this->actingAs($admin)
            ->get("/admin/enquiries/{$enquiry->id}")
            ->assertSee('Called the investor; documents expected next week.')
            ->assertSee($admin->name);
    }

    public function test_a_note_requires_a_body(): void
    {
        $admin = User::factory()->admin()->create();
        $enquiry = Enquiry::factory()->create();

        $this->actingAs($admin)
            ->post("/admin/enquiries/{$enquiry->id}/notes", ['body' => ''])
            ->assertSessionHasErrors('body');

        $this->assertSame(0, $enquiry->notes()->count());
    }

    public function test_investors_cannot_change_status_or_add_notes(): void
    {
        $investor = User::factory()->create();
        $enquiry = Enquiry::factory()->create();

        $this->actingAs($investor)
            ->put("/admin/enquiries/{$enquiry->id}", ['status' => 'closed'])
            ->assertForbidden();

        $this->actingAs($investor)
            ->post("/admin/enquiries/{$enquiry->id}/notes", ['body' => 'Not allowed'])
            ->assertForbidden();

        $this->assertSame('new', $enquiry->refresh()->status);
        $this->assertSame(0, $enquiry->notes()->count());
    }

    public function test_staff_are_sent_to_the_console_after_signing_in(): void
    {
        $admin = User::factory()->admin()->create(['email' => 'desk@example.com']);

        $this->post('/login', [
            'email' => 'desk@example.com',
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin);
    }
}
