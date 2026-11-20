<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminSectorController extends Controller
{
    /**
     * Sector catalogue with status and keyword filters.
     */
    public function index(Request $request): View
    {
        $filters = [
            'status' => $request->string('status')->toString(),
            'q' => $request->string('q')->toString(),
        ];

        $industries = Industry::query()
            ->when($filters['status'] === 'active', fn ($query) => $query->where('is_active', true))
            ->when($filters['status'] === 'inactive', fn ($query) => $query->where('is_active', false))
            ->when($filters['q'] !== '', function ($query) use ($filters) {
                $term = '%'.$filters['q'].'%';

                $query->where(function ($query) use ($term) {
                    $query->where('name', 'like', $term)
                        ->orWhere('slug', 'like', $term);
                });
            })
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('admin.sectors.index', [
            'industries' => $industries,
            'filters' => $filters,
            'counts' => [
                'all' => Industry::query()->count(),
                'active' => Industry::query()->where('is_active', true)->count(),
                'inactive' => Industry::query()->where('is_active', false)->count(),
            ],
        ]);
    }

    /**
     * Form for adding a sector.
     */
    public function create(): View
    {
        return view('admin.sectors.create', [
            'industry' => new Industry([
                'is_active' => true,
                'sort_order' => (int) Industry::query()->max('sort_order') + 1,
            ]),
        ]);
    }

    /**
     * Store a new sector.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'slug' => [
                'nullable',
                'string',
                'max:140',
                'alpha_dash',
                Rule::unique('industries', 'slug')->ignore(null),
            ],
            'icon' => ['nullable', 'string', 'max:50'],
            'summary' => ['nullable', 'string', 'max:300'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        $isActive = $request->boolean('is_active');

        Industry::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'] ?? Str::slug($validated['name']),
            'icon' => $validated['icon'] ?? null,
            'summary' => $validated['summary'] ?? null,
            'is_active' => $isActive,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()
            ->route('admin.sectors.index')
            ->with('success', $isActive
                ? 'Sector added. It is live on the public sectors pages.'
                : 'Sector added and hidden from the public pages.');
    }

    /**
     * Form for editing a sector.
     */
    public function edit(Industry $industry): View
    {
        return view('admin.sectors.edit', ['industry' => $industry]);
    }

    /**
     * Update a sector.
     */
    public function update(Request $request, Industry $industry): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'slug' => [
                'nullable',
                'string',
                'max:140',
                'alpha_dash',
                Rule::unique('industries', 'slug')->ignore($industry->id),
            ],
            'icon' => ['nullable', 'string', 'max:50'],
            'summary' => ['nullable', 'string', 'max:300'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        $isActive = $request->boolean('is_active');

        $industry->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'] ?? Str::slug($validated['name']),
            'icon' => $validated['icon'] ?? null,
            'summary' => $validated['summary'] ?? null,
            'is_active' => $isActive,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()
            ->route('admin.sectors.index')
            ->with('success', $isActive
                ? 'Sector updated. The public pages reflect the change immediately.'
                : 'Sector updated and hidden from the public pages.');
    }
}
