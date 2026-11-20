<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use App\Models\InvestmentOpportunity;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminOpportunityController extends Controller
{
    /**
     * Investment opportunities listing with basic filters.
     */
    public function index(Request $request): View
    {
        $query = InvestmentOpportunity::query()
            ->published()
            ->with('industry');

        $search = trim((string) $request->query('q'));
        if ($search !== '') {
            $query->where(function (Builder $q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('summary', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $sector = (string) $request->query('sector');
        if ($sector !== '') {
            $query->whereHas('industry', fn (Builder $q) => $q->where('slug', $sector));
        }

        $opportunities = $query->orderBy('sort_order')->paginate(20)->withQueryString();
        $sectors = Industry::query()->where('is_active', true)->orderBy('name')->get(['id', 'name', 'slug']);

        return view('admin.opportunities.index', [
            'opportunities' => $opportunities,
            'sectors' => $sectors,
            'search' => $search,
            'activeSector' => $sector,
            'counts' => [
                'all' => InvestmentOpportunity::query()->count(),
                'published' => InvestmentOpportunity::query()->published()->count(),
            ],
        ]);
    }

    /**
     * Form for adding an investment opportunity.
     */
    public function create(): View
    {
        $industries = Industry::query()->where('is_active', true)->orderBy('name')->get(['id', 'name', 'slug']);

        return view('admin.opportunities.create', [
            'industries' => $industries,
            'opportunity' => new InvestmentOpportunity([
                'status' => 'published',
                'is_featured' => false,
                'investment_min' => 'Provisional — to be confirmed',
                'investment_max' => null,
            ]),
        ]);
    }

    /**
     * Store a new investment opportunity.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'summary' => ['required', 'string', 'max:500'],
            'industry_id' => ['required', 'exists:industries,id'],
            'location' => ['nullable', 'string', 'max:200'],
            'investment_min' => ['nullable', 'string', 'max:100'],
            'investment_max' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:published,draft'],
            'is_featured' => ['nullable', 'boolean'],
            'image_key' => ['nullable', 'string', 'max:80'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        InvestmentOpportunity::create([
            'title' => $validated['title'],
            'summary' => $validated['summary'],
            'industry_id' => $validated['industry_id'],
            'location' => $validated['location'] ?? 'Region to be confirmed',
            'investment_min' => $validated['investment_min'] ?? 'Provisional — to be confirmed',
            'investment_max' => $validated['investment_max'] ?? null,
            'status' => $validated['status'],
            'is_featured' => $request->boolean('is_featured'),
            'image_key' => $validated['image_key'] ?? 'opportunities.city',
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()
            ->route('admin.opportunities.index')
            ->with('success', 'Investment opportunity added.');
    }

    /**
     * Form for editing an investment opportunity.
     */
    public function edit(InvestmentOpportunity $opp): View
    {
        $industries = Industry::query()->where('is_active', true)->orderBy('name')->get(['id', 'name', 'slug']);

        return view('admin.opportunities.edit', [
            'industries' => $industries,
            'opportunity' => $opp,
        ]);
    }

    /**
     * Update an investment opportunity.
     */
    public function update(Request $request, InvestmentOpportunity $opp): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'summary' => ['required', 'string', 'max:500'],
            'industry_id' => ['required', 'exists:industries,id'],
            'location' => ['nullable', 'string', 'max:200'],
            'investment_min' => ['nullable', 'string', 'max:100'],
            'investment_max' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:published,draft'],
            'is_featured' => ['nullable', 'boolean'],
            'image_key' => ['nullable', 'string', 'max:80'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        $opp->update([
            'title' => $validated['title'],
            'summary' => $validated['summary'],
            'industry_id' => $validated['industry_id'],
            'location' => $validated['location'] ?? 'Region to be confirmed',
            'investment_min' => $validated['investment_min'] ?? 'Provisional — to be confirmed',
            'investment_max' => $validated['investment_max'] ?? null,
            'status' => $validated['status'],
            'is_featured' => $request->boolean('is_featured'),
            'image_key' => $validated['image_key'] ?? 'opportunities.city',
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()
            ->route('admin.opportunities.index')
            ->with('success', 'Investment opportunity updated.');
    }
}
