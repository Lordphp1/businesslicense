<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    /**
     * Enquiry queue with status, assignment and keyword filters.
     */
    public function index(Request $request): View
    {
        $filters = [
            'status' => $request->string('status')->toString(),
            'assignment' => $request->string('assignment')->toString(),
            'q' => $request->string('q')->toString(),
        ];

        $enquiries = Enquiry::query()
            ->with(['industry', 'assignee'])
            ->when(
                in_array($filters['status'], Enquiry::STATUSES, true),
                fn ($query) => $query->where('status', $filters['status']),
            )
            ->when($filters['assignment'] === 'unassigned', fn ($query) => $query->whereNull('assigned_to'))
            ->when($filters['assignment'] === 'mine', fn ($query) => $query->where('assigned_to', $request->user()->id))
            ->when($filters['q'] !== '', function ($query) use ($filters) {
                $term = '%'.$filters['q'].'%';

                $query->where(function ($query) use ($term) {
                    $query->where('name', 'like', $term)
                        ->orWhere('email', 'like', $term)
                        ->orWhere('subject', 'like', $term)
                        ->orWhere('message', 'like', $term);
                });
            })
            ->latest()
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.enquiries.index', [
            'enquiries' => $enquiries,
            'filters' => $filters,
            'statusCounts' => Enquiry::query()
                ->selectRaw('status, count(*) as aggregate')
                ->groupBy('status')
                ->pluck('aggregate', 'status'),
        ]);
    }

    /**
     * Single enquiry with correspondence history and handling controls.
     */
    public function show(Enquiry $enquiry): View
    {
        $enquiry->load(['user', 'industry', 'assignee', 'notes.author']);

        return view('admin.enquiries.show', [
            'enquiry' => $enquiry,
            'staff' => User::query()->where('is_admin', true)->orderBy('name')->get(['id', 'name']),
        ]);
    }

    /**
     * Update handling status and desk assignment.
     */
    public function update(Request $request, Enquiry $enquiry): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:'.implode(',', Enquiry::STATUSES)],
            'assigned_to' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        if ($validated['status'] === 'assigned' && blank($validated['assigned_to'] ?? null)) {
            return back()
                ->withInput()
                ->withErrors(['assigned_to' => 'Choose a staff member before marking an enquiry as assigned.']);
        }

        $enquiry->status = $validated['status'];
        $enquiry->assigned_to = $validated['assigned_to'] ?? null;
        $enquiry->handled_at = $validated['status'] === 'closed' ? now() : null;
        $enquiry->save();

        return redirect()
            ->route('admin.enquiries.show', $enquiry)
            ->with('success', 'Enquiry updated.');
    }

    /**
     * Record an internal note against an enquiry.
     */
    public function storeNote(Request $request, Enquiry $enquiry): RedirectResponse
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $enquiry->notes()->create([
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
        ]);

        return redirect()
            ->route('admin.enquiries.show', $enquiry)
            ->with('success', 'Note added.');
    }
}
