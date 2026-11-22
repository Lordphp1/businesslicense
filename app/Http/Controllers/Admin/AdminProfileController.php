<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminProfileController extends Controller
{
    /**
     * Display the admin profile edit form.
     */
    public function edit(): View
    {
        $user = User::where('is_admin', true)->firstOrFail();

        return view('admin.profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the admin profile.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'country' => ['nullable', 'string', 'max:100'],
            'company' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::where('is_admin', true)->firstOrFail();

        $user->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'country' => $validated['country'],
            'company' => $validated['company'],
        ]);

        return redirect()
            ->route('admin.profile.edit')
            ->with('success', 'Profile updated successfully.');
    }
}