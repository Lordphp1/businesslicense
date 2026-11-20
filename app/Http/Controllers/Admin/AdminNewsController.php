<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsPost;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminNewsController extends Controller
{
    /**
     * News and publications listing.
     */
    public function index(Request $request): View
    {
        $query = NewsPost::query()->published();

        $search = trim((string) $request->query('q'));
        if ($search !== '') {
            $query->where(function (Builder $q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%");
            });
        }

        $featured = $request->boolean('featured');

        $posts = $query
            ->when($featured, fn (Builder $q) => $q->where('is_featured', true))
            ->when(! $featured, fn (Builder $q) => $q->where('is_featured', false))
            ->orderByDesc('published_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.news.index', [
            'posts' => $posts,
            'search' => $search,
            'featured' => $featured,
            'counts' => [
                'all' => NewsPost::query()->count(),
                'published' => NewsPost::query()->published()->count(),
                'featured' => NewsPost::query()->where('is_featured', true)->count(),
            ],
        ]);
    }

    /**
     * Form for adding a news post.
     */
    public function create(): View
    {
        return view('admin.news.create', [
            'post' => new NewsPost([
                'is_featured' => false,
                'published_at' => null,
            ]),
        ]);
    }

    /**
     * Store a new news post.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'excerpt' => ['required', 'string', 'max:300'],
            'body' => ['required', 'string', 'max:10000'],
            'category' => ['required', 'string'],
            'image_key' => ['nullable', 'string', 'max:80'],
            'is_featured' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ]);

        $publishedAt = $validated['published_at'] ?? null;

        NewsPost::create([
            'title' => $validated['title'],
            'excerpt' => $validated['excerpt'],
            'body' => $validated['body'],
            'category' => $validated['category'],
            'image_key' => $validated['image_key'] ?? 'news.newspaper',
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $publishedAt,
        ]);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'News post added.');
    }

    /**
     * Form for editing a news post.
     */
    public function edit(NewsPost $post): View
    {
        return view('admin.news.edit', ['post' => $post]);
    }

    /**
     * Update a news post.
     */
    public function update(Request $request, NewsPost $post): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'excerpt' => ['required', 'string', 'max:300'],
            'body' => ['required', 'string', 'max:10000'],
            'category' => ['required', 'string'],
            'image_key' => ['nullable', 'string', 'max:80'],
            'is_featured' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ]);

        $publishedAt = $validated['published_at'] ?? $post->published_at;

        $post->update([
            'title' => $validated['title'],
            'excerpt' => $validated['excerpt'],
            'body' => $validated['body'],
            'category' => $validated['category'],
            'image_key' => $validated['image_key'] ?? $post->image_key,
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $publishedAt,
        ]);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'News post updated.');
    }
}
