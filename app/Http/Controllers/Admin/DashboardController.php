<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Back-office overview: enquiry pipeline at a glance.
     */
    public function index(): View
    {
        $counts = Enquiry::query()
            ->selectRaw('status, count(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $recent = Enquiry::query()
            ->with(['industry', 'assignee'])
            ->latest()
            ->orderByDesc('id')
            ->limit(8)
            ->get();

        return view('admin.dashboard', [
            'counts' => $counts,
            'recent' => $recent,
            'unassigned' => Enquiry::query()->whereNull('assigned_to')->where('status', '!=', 'closed')->count(),
            'lastSevenDays' => Enquiry::query()->where('created_at', '>=', now()->subDays(7))->count(),
            'anonymous' => Enquiry::query()->whereNull('user_id')->count(),
        ]);
    }
}
