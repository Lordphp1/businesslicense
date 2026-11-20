<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermitRequest;
use App\Models\Permit;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermitController extends Controller
{
    /**
     * Permit catalogue with status and keyword filters.
     */
    public function index(Request $request): View
    {
        $filters = [
            'status' => $request->string('status')->toString(),
            'q' => $request->string('q')->toString(),
        ];

        $permits = Permit::query()
            ->when($filters['status'] === 'active', fn ($query) => $query->where('is_active', true))
            ->when($filters['status'] === 'inactive', fn ($query) => $query->where('is_active', false))
            ->when($filters['q'] !== '', function ($query) use ($filters) {
                $term = '%'.$filters['q'].'%';

                $query->where(function ($query) use ($term) {
                    $query->where('name', 'like', $term)
                        ->orWhere('authority', 'like', $term)
                        ->orWhere('slug', 'like', $term);
                });
            })
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('admin.permits.index', [
            'permits' => $permits,
            'filters' => $filters,
            'counts' => [
                'all' => Permit::query()->count(),
                'active' => Permit::query()->where('is_active', true)->count(),
                'inactive' => Permit::query()->where('is_active', false)->count(),
            ],
        ]);
    }

    /**
     * Form for adding a permit to the catalogue.
     */
    public function create(): View
    {
        return view('admin.permits.create', [
            'permit' => new Permit([
                'currency' => 'USD',
                'sort_order' => (int) Permit::query()->max('sort_order') + 1,
                'is_active' => true,
            ]),
        ]);
    }

    /**
     * Store a new permit and its pricing.
     */
    public function store(PermitRequest $request): RedirectResponse
    {
        $isActive = $request->boolean('is_active');

        Permit::create($this->attributes($request->validated(), $isActive));

        return redirect()
            ->route('admin.permits.index')
            ->with('success', $isActive
                ? 'Permit added. It is live on the public licensing page.'
                : 'Permit added and hidden from the public page.');
    }

    /**
     * Form for editing a permit and its pricing.
     */
    public function edit(Permit $permit): View
    {
        return view('admin.permits.edit', ['permit' => $permit]);
    }

    /**
     * Update a permit and its pricing.
     */
    public function update(PermitRequest $request, Permit $permit): RedirectResponse
    {
        $isActive = $request->boolean('is_active');

        $permit->update($this->attributes($request->validated(), $isActive));

        return redirect()
            ->route('admin.permits.index')
            ->with('success', $isActive
                ? 'Permit updated. The public page reflects the change immediately.'
                : 'Permit updated and hidden from the public page.');
    }

    /**
     * Map validated input to model attributes.
     *
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function attributes(array $validated, bool $isActive): array
    {
        return [
            'name' => $validated['name'],
            'slug' => $validated['slug'] ?? Str::slug($validated['name']),
            'authority' => $validated['authority'] ?? null,
            'summary' => $validated['summary'] ?? null,
            'fee' => $validated['fee'] ?? null,
            'currency' => strtoupper($validated['currency']),
            'turnaround' => $validated['turnaround'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $isActive,
        ];
    }
}
