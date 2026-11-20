<?php

namespace Tests\Feature;

use App\Models\Enquiry;
use App\Models\User;
use Database\Seeders\SiteContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class InvestorAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(SiteContentSeeder::class);
    }

    public function test_guest_is_redirected_from_the_dashboard_to_the_login_page(): void
    {
        $this->get('/dashboard')->assertRedirect(route('login'));
        $this->get('/dashboard/profile')->assertRedirect(route('login'));
    }

    public function test_login_and_registration_pages_render_their_forms(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('Sign in')
            ->assertSee('name="password"', false);

        $this->get('/register')
            ->assertOk()
            ->assertSee('name="password_confirmation"', false)
            ->assertSee('name="investor_type"', false);
    }

    public function test_an_investor_can_register_and_is_signed_in(): void
    {
        $response = $this->post('/register', [
            'name' => 'Amara Osei',
            'email' => 'amara.osei@example.com',
            'company' => 'Osei Holdings',
            'country' => 'Ghana',
            'phone' => '+233 30 123 4567',
            'investor_type' => 'company',
            'password' => 'meridian2026',
            'password_confirmation' => 'meridian2026',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();

        $user = User::query()->where('email', 'amara.osei@example.com')->firstOrFail();

        $this->assertSame('Osei Holdings', $user->company);
        $this->assertSame('company', $user->investor_type);
        $this->assertNotNull($user->onboarding_completed_at);
        $this->assertTrue($user->hasCompletedProfile());
        $this->assertTrue(Hash::check('meridian2026', $user->password));
    }

    public function test_registration_without_country_or_investor_type_leaves_onboarding_incomplete(): void
    {
        $this->post('/register', [
            'name' => 'Bare Minimum',
            'email' => 'bare.minimum@example.com',
            'password' => 'meridian2026',
            'password_confirmation' => 'meridian2026',
        ])->assertRedirect(route('dashboard'));

        $user = User::query()->where('email', 'bare.minimum@example.com')->firstOrFail();

        $this->assertNull($user->onboarding_completed_at);
        $this->assertFalse($user->hasCompletedProfile());
    }

    public function test_registration_rejects_a_weak_password_and_duplicate_email(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        $this->post('/register', [
            'name' => 'Test Investor',
            'email' => 'taken@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
        ])->assertSessionHasErrors(['email', 'password']);

        $this->assertGuest();
        $this->assertSame(1, User::query()->count());
    }

    public function test_an_investor_can_sign_in_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'investor@example.com',
            'password' => Hash::make('meridian2026'),
        ]);

        $this->post('/login', [
            'email' => 'investor@example.com',
            'password' => 'meridian2026',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_sign_in_fails_with_an_incorrect_password(): void
    {
        User::factory()->create([
            'email' => 'investor@example.com',
            'password' => Hash::make('meridian2026'),
        ]);

        $this->post('/login', [
            'email' => 'investor@example.com',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_sign_in_is_rate_limited_after_five_failed_attempts(): void
    {
        User::factory()->create([
            'email' => 'investor@example.com',
            'password' => Hash::make('meridian2026'),
        ]);

        foreach (range(1, 5) as $attempt) {
            $this->post('/login', [
                'email' => 'investor@example.com',
                'password' => 'wrong-password',
            ])->assertSessionHasErrors('email');
        }

        $this->post('/login', [
            'email' => 'investor@example.com',
            'password' => 'meridian2026',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_an_investor_can_sign_out(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/logout')
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }

    public function test_the_dashboard_lists_only_the_signed_in_investors_enquiries(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        Enquiry::factory()->create([
            'user_id' => $user->id,
            'subject' => 'My manufacturing enquiry',
        ]);

        Enquiry::factory()->create([
            'user_id' => $other->id,
            'subject' => 'Someone elses enquiry',
        ]);

        Enquiry::factory()->create([
            'user_id' => null,
            'subject' => 'Anonymous enquiry',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
        $response->assertSee('My manufacturing enquiry');
        $response->assertDontSee('Someone elses enquiry');
        $response->assertDontSee('Anonymous enquiry');
    }

    public function test_an_enquiry_submitted_while_signed_in_is_linked_to_the_account(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/contact', [
            'name' => $user->name,
            'email' => $user->email,
            'subject' => 'Expansion enquiry',
            'message' => 'We would like to discuss expanding our existing operation.',
        ])->assertRedirect(route('contact'));

        $this->assertDatabaseHas('enquiries', [
            'user_id' => $user->id,
            'subject' => 'Expansion enquiry',
        ]);
    }

    public function test_an_investor_can_update_their_profile_and_complete_onboarding(): void
    {
        $user = User::factory()->create([
            'country' => null,
            'investor_type' => null,
            'onboarding_completed_at' => null,
        ]);

        $response = $this->actingAs($user)->put('/dashboard/profile', [
            'name' => 'Amara Osei',
            'email' => 'amara.osei@example.com',
            'phone' => '+233 30 123 4567',
            'country' => 'Ghana',
            'company' => 'Osei Holdings',
            'investor_type' => 'company',
        ]);

        $response->assertRedirect(route('dashboard.profile.edit'));
        $response->assertSessionHas('success');

        $user->refresh();

        $this->assertSame('Amara Osei', $user->name);
        $this->assertSame('Ghana', $user->country);
        $this->assertNotNull($user->onboarding_completed_at);
        $this->assertTrue($user->hasCompletedProfile());
    }

    public function test_changing_the_password_requires_the_current_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('meridian2026'),
        ]);

        $payload = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'newpassword2026',
            'password_confirmation' => 'newpassword2026',
        ];

        $this->actingAs($user)
            ->put('/dashboard/profile', $payload)
            ->assertSessionHasErrors('current_password');

        $this->assertTrue(Hash::check('meridian2026', $user->refresh()->password));

        $this->actingAs($user)
            ->put('/dashboard/profile', $payload + ['current_password' => 'meridian2026'])
            ->assertSessionHasNoErrors();

        $this->assertTrue(Hash::check('newpassword2026', $user->refresh()->password));
    }

    public function test_a_signed_in_investor_is_redirected_away_from_the_login_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/login')->assertRedirect(route('dashboard'));
        $this->actingAs($user)->get('/register')->assertRedirect(route('dashboard'));
    }
}
