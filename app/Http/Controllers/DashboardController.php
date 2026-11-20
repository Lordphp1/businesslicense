<?php

namespace App\Http\Controllers;

use App\Models\NewsPost;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Investor dashboard: profile status and own enquiries.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $enquiries = $user->enquiries()
            ->with('industry')
            ->latest()
            ->limit(10)
            ->get();

        $statusCounts = $user->enquiries()
            ->selectRaw('status, count(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $news = NewsPost::query()
            ->published()
            ->limit(2)
            ->get(['slug', 'title', 'category', 'published_at']);

        return view('dashboard.index', [
            'user' => $user,
            'enquiries' => $enquiries,
            'statusCounts' => $statusCounts,
            'news' => $news,
        ]);
    }
}
