@extends('layouts.admin')

@section('title', 'Enquiries')
@section('crumb', 'Enquiries')

@section('content')
    <div class="admin-page-head">
        <div>
            <span class="eyebrow">Queue</span>
            <h1>Enquiries</h1>
            <p class="lead mb-0">{{ $enquiries->total() }} {{ Str::plural('record', $enquiries->total()) }} matching the current view.</p>
        </div>
        <div class="admin-status-chips">
            @php
                $statusLinks = [
                    '' => 'All',
                    'new' => 'New',
                    'assigned' => 'Assigned',
                    'closed' => 'Closed',
                ];
            @endphp
            @foreach ($statusLinks as $value => $label)
                <a class="admin-chip {{ $filters['status'] === $value ? 'is-active' : '' }}"
                    href="{{ route('admin.enquiries.index', array_filter(['status' => $value, 'assignment' => $filters['assignment'], 'q' => $filters['q']])) }}"
                    @if ($filters['status'] === $value) aria-current="true" @endif>
                    {{ $label }}
                    @if ($value !== '')
                        <span>{{ $statusCounts->get($value, 0) }}</span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>

    <form class="filter-bar filter-bar--panel" method="GET" action="{{ route('admin.enquiries.index') }}" aria-label="Filter enquiries">
        @if ($filters['status'] !== '')
            <input type="hidden" name="status" value="{{ $filters['status'] }}">
        @endif
        <div class="filter-bar__field filter-bar__field--grow">
            <label for="q">Search</label>
            <input type="search" id="q" name="q" value="{{ $filters['q'] }}"
                placeholder="Name, email, subject or message">
        </div>
        <div class="filter-bar__field">
            <label for="assignment">Ownership</label>
            <select id="assignment" name="assignment">
                <option value="">Everyone</option>
                <option value="unassigned" @selected($filters['assignment'] === 'unassigned')>Unassigned</option>
                <option value="mine" @selected($filters['assignment'] === 'mine')>Assigned to me</option>
            </select>
        </div>
        <div class="filter-bar__actions">
            <button type="submit" class="btn btn-mia btn-primary-mia">
                Apply <x-icon name="search" class="icon" />
            </button>
            @if ($filters['q'] !== '' || $filters['assignment'] !== '' || $filters['status'] !== '')
                <a class="filter-bar__clear" href="{{ route('admin.enquiries.index') }}">
                    <x-icon name="x" class="icon" /> Clear
                </a>
            @endif
        </div>
    </form>

    <section class="dash-block">
        @if ($enquiries->isEmpty())
            <div class="empty-state empty-state--panel">
                <h3>Nothing in this view</h3>
                <p>
                    @if ($filters['q'] !== '')
                        No enquiries match “{{ $filters['q'] }}”.
                    @else
                        No enquiries match the selected filters.
                    @endif
                </p>
                <a class="btn btn-mia btn-outline-mia" href="{{ route('admin.enquiries.index') }}">Reset filters</a>
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
                            <th scope="col"><span class="visually-hidden">Open</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($enquiries as $enquiry)
                            <tr>
                                <td class="admin-nowrap">
                                    {{ $enquiry->created_at->format('j M Y') }}
                                    <span class="admin-sub">{{ $enquiry->created_at->format('H:i') }}</span>
                                </td>
                                <td>
                                    <a class="dash-table__title" href="{{ route('admin.enquiries.show', $enquiry) }}">
                                        {{ $enquiry->name }}
                                    </a>
                                    <span class="admin-sub">{{ $enquiry->email }}</span>
                                </td>
                                <td>
                                    {{ $enquiry->subject ?: Str::limit($enquiry->message, 60) }}
                                    @if ($enquiry->user_id !== null)
                                        <span class="admin-tag">Account</span>
                                    @endif
                                </td>
                                <td>{{ $enquiry->industry?->name ?? '—' }}</td>
                                <td>{{ $enquiry->assignee?->name ?? '—' }}</td>
                                <td>
                                    <span class="status-badge status-badge--{{ $enquiry->status }}">
                                        {{ ucfirst($enquiry->status) }}
                                    </span>
                                </td>
                                <td class="admin-nowrap">
                                    <a class="textlink" href="{{ route('admin.enquiries.show', $enquiry) }}">
                                        Open <x-icon name="arrow-right" />
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="admin-pagination">
                {{ $enquiries->links() }}
            </div>
        @endif
    </section>
@endsection
