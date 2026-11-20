@extends('layouts.admin')

@section('title', 'Overview')
@section('crumb', 'Overview')

@section('content')
    <div class="admin-page-head">
        <div>
            <span class="eyebrow">Advisory desk</span>
            <h1>Pipeline overview</h1>
            <p class="lead mb-0">Enquiries submitted through the public site, and where each one stands.</p>
        </div>
        <a class="btn btn-mia btn-primary-mia" href="{{ route('admin.enquiries.index') }}">
            Open the queue <x-icon name="arrow-right" class="icon icon--arrow" />
        </a>
    </div>

    <div class="admin-stats">
        <a class="admin-stat" href="{{ route('admin.enquiries.index', ['status' => 'new']) }}">
            <span class="admin-stat__n">{{ $counts->get('new', 0) }}</span>
            <span class="admin-stat__l">New</span>
            <span class="admin-stat__d">Not yet assigned</span>
        </a>
        <a class="admin-stat" href="{{ route('admin.enquiries.index', ['status' => 'assigned']) }}">
            <span class="admin-stat__n">{{ $counts->get('assigned', 0) }}</span>
            <span class="admin-stat__l">Assigned</span>
            <span class="admin-stat__d">With an advisor</span>
        </a>
        <a class="admin-stat" href="{{ route('admin.enquiries.index', ['status' => 'closed']) }}">
            <span class="admin-stat__n">{{ $counts->get('closed', 0) }}</span>
            <span class="admin-stat__l">Closed</span>
            <span class="admin-stat__d">Handled and filed</span>
        </a>
        <a class="admin-stat" href="{{ route('admin.enquiries.index', ['assignment' => 'unassigned']) }}">
            <span class="admin-stat__n">{{ $unassigned }}</span>
            <span class="admin-stat__l">Needs an owner</span>
            <span class="admin-stat__d">Open, unassigned</span>
        </a>
    </div>

    <p class="admin-meta-line">
        <span><strong>{{ $lastSevenDays }}</strong> received in the last 7 days</span>
        <span><strong>{{ $anonymous }}</strong> from visitors without an account</span>
    </p>

    <section class="dash-block">
        <div class="dash-block__head">
            <h2>Latest enquiries</h2>
            <a class="textlink" href="{{ route('admin.enquiries.index') }}">Full queue <x-icon name="arrow-right" /></a>
        </div>

        @if ($recent->isEmpty())
            <div class="empty-state empty-state--panel">
                <h3>No enquiries yet</h3>
                <p>Enquiries submitted through the contact form will appear here.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th scope="col">Received</th>
                            <th scope="col">Investor</th>
                            <th scope="col">Enquiry</th>
                            <th scope="col">Sector</th>
                            <th scope="col">Owner</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recent as $enquiry)
                            <tr>
                                <td>{{ $enquiry->created_at->format('j M') }}</td>
                                <td>
                                    <a class="dash-table__title" href="{{ route('admin.enquiries.show', $enquiry) }}">
                                        {{ $enquiry->name }}
                                    </a>
                                    <span class="admin-sub">{{ $enquiry->email }}</span>
                                </td>
                                <td>{{ $enquiry->subject ?: Str::limit($enquiry->message, 48) }}</td>
                                <td>{{ $enquiry->industry?->name ?? '—' }}</td>
                                <td>{{ $enquiry->assignee?->name ?? 'Unassigned' }}</td>
                                <td>
                                    <span class="status-badge status-badge--{{ $enquiry->status }}">
                                        {{ ucfirst($enquiry->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection
