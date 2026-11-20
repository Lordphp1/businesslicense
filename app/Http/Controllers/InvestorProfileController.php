<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class InvestorProfileController extends Controller
{
    /**
     * Show the investor profile form.
     */
    public function edit(Request $request): View
    {
        return view('dashboard.profile', ['user' => $request->user()]);
    }

    /**
     * Update the investor profile and, optionally, the password.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:190', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:40'],
            'country' => ['nullable', 'string', 'max:80'],
            'company' => ['nullable', 'string', 'max:190'],
            'investor_type' => ['nullable', 'in:individual,company,fund,advisor'],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'confirmed', Password::min(10)->letters()->numbers()],
        ]);

        if (filled($validated['password'] ?? null)) {
            $user->password = $validated['password'];
        }

        /** @var array<string, string|null> $profile */
        $profile = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        foreach (['phone', 'country', 'company', 'investor_type'] as $field) {
            if (array_key_exists($field, $validated)) {
                $profile[$field] = $validated[$field];
            }
        }

        $user->fill($profile);

        if ($user->onboarding_completed_at === null && filled($user->country) && filled($user->investor_type)) {
            $user->onboarding_completed_at = now();
        }

        $user->save();

        return redirect()
            ->route('dashboard.profile.edit')
            ->with('success', 'Your investor profile has been updated.');
    }
}
