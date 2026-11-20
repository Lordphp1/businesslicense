<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Industry;
use App\Models\InvestmentOpportunity;
use App\Models\NewsPost;
use App\Models\Permit;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Homepage — the flagship marketing page.
     */
    public function home(): View
    {
        $featured = InvestmentOpportunity::query()
            ->published()
            ->where('is_featured', true)
            ->with('industry')
            ->first();

        $moreOpportunities = InvestmentOpportunity::query()
            ->published()
            ->where('is_featured', false)
            ->with('industry')
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        $industries = Industry::query()
            ->where('is_active', true)
            ->where('is_priority', true)
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        $news = NewsPost::query()->published()->limit(4)->get();

        return view('pages.home', [
            'featured' => $featured,
            'moreOpportunities' => $moreOpportunities,
            'industries' => $industries,
            'news' => $news,
        ]);
    }

    /**
     * About the agency (provisional content pending agency data).
     */
    public function about(): View
    {
        return view('pages.about');
    }

    /**
     * Investor services overview.
     */
    public function services(): View
    {
        return view('pages.services');
    }

    /**
     * Business establishment guide.
     */
    public function startBusiness(): View
    {
        return view('pages.start-business');
    }

    /**
     * Business registration assistance information.
     */
    public function registration(): View
    {
        return view('pages.registration');
    }

    /**
     * Business licensing assistance information.
     */
    public function licensing(): View
    {
        return view('pages.licensing', [
            'permits' => Permit::query()->active()->get(),
        ]);
    }

    /**
     * Contact page (placeholder contact details pending agency data).
     */
    public function contact(): View
    {
        $industries = Industry::query()->where('is_active', true)->orderBy('name')->get(['id', 'name']);

        return view('pages.contact', ['industries' => $industries]);
    }

    /**
     * Store a public enquiry from the contact form.
     */
    public function storeContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:40'],
            'country' => ['nullable', 'string', 'max:80'],
            'subject' => ['nullable', 'string', 'max:190'],
            'industry_id' => ['nullable', 'exists:industries,id'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        Enquiry::create($validated + [
            'source' => 'contact-page',
            'user_id' => $request->user()?->id,
        ]);

        return redirect()
            ->route('contact')
            ->with('success', 'Thank you. Your enquiry has been received and will be reviewed by our advisory desk.');
    }

    /**
     * Investment opportunities listing with basic filters.
     */
    public function opportunities(Request $request): View
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

        $opportunities = $query->orderBy('sort_order')->get();
        $sectors = Industry::query()->where('is_active', true)->orderBy('name')->get(['id', 'name', 'slug']);

        return view('pages.opportunities.index', [
            'opportunities' => $opportunities,
            'sectors' => $sectors,
            'search' => $search,
            'activeSector' => $sector,
        ]);
    }

    /**
     * Priority sectors listing.
     */
    public function sectors(): View
    {
        $industries = Industry::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('pages.sectors.index', ['industries' => $industries]);
    }

    /**
     * Single sector detail page.
     */
    public function showSector(Industry $industry): View
    {
        $opportunities = InvestmentOpportunity::query()
            ->published()
            ->where('industry_id', $industry->id)
            ->orderBy('sort_order')
            ->get();

        $siblings = Industry::query()
            ->where('is_active', true)
            ->where('id', '!=', $industry->id)
            ->orderBy('sort_order')
            ->limit(5)
            ->get(['slug', 'name', 'icon']);

        return view('pages.sectors.show', [
            'industry' => $industry,
            'opportunities' => $opportunities,
            'siblings' => $siblings,
        ]);
    }

    /**
     * News and publications listing.
     */
    public function news(): View
    {
        $featured = NewsPost::query()->published()->where('is_featured', true)->first();

        $posts = NewsPost::query()
            ->published()
            ->when($featured, fn (Builder $q) => $q->where('id', '!=', $featured->id))
            ->paginate(9);

        return view('pages.news.index', ['posts' => $posts, 'featured' => $featured]);
    }

    /**
     * Single news post.
     */
    public function showNews(NewsPost $post): View
    {
        abort_unless($post->published_at !== null, 404);

        $related = NewsPost::query()
            ->published()
            ->where('id', '!=', $post->id)
            ->limit(3)
            ->get(['slug', 'title', 'published_at']);

        return view('pages.news.show', ['post' => $post, 'related' => $related]);
    }
}
