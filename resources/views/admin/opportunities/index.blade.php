@extends('layouts.admin')

@section('title', 'Opportunities')
@section('crumb', 'Opportunities')

@section('content')
    <div class="admin-page-head">
        <div>
            <span class="eyebrow">Catalogue</span>
            <h1>Investment Opportunities</h1>
            <p class="lead mb-0">
                {{ $counts['published'] }} {{ Str::plural('opportunity', $counts['published']) }} published.
            </p>
        </div>
        <a class="btn btn-mia btn-gold-mia" href="{{ route('admin.opportunities.create') }}">
            Add opportunity <x-icon name="plus" class="icon" />
        </a>
    </div>

    <div class="admin-status-chips">
        @php
            $statusLinks = [
                '' => ['label' => 'All', 'count' => $counts['all']],
                'published' => ['label' => 'Published', 'count' => $counts['published']],
                'draft' => ['label' => 'Draft', 'count' => $counts['all'] - $counts['published']],
            ];
        @endphp
        @foreach ($statusLinks as $value => $status)
            <a class="admin-chip {{ $filters['status'] === $value ? 'is-active' : '' }}"
                href="{{ route('admin.opportunities.index', array_filter(['status' => $value, 'sector' => $filters['sector'], 'q' => $filters['q']])) }}"
                @if ($filters['status'] === $value) aria-current="true" @endif>
                {{ $status['label'] }}
                <span>{{ $status['count'] }}</span>
            </a>
        @endforeach
    </div>

    <form class="filter-bar filter-bar--panel" method="GET" action="{{ route('admin.opportunities.index') }}" aria-label="Filter opportunities">
        @if ($filters['status'] !== '')
            <input type="hidden" name="status" value="{{ $filters['status'] }}">
        @endif
        @if ($filters['sector'] !== '')
            <input type="hidden" name="sector" value="{{ $filters['sector'] }}">
        @endif
        <div class="filter-bar__field filter-bar__field--grow">
            <label for="q">Search</label>
            <input type="search" id="q" name="q" value="{{ $filters['q'] }}"
                placeholder="Title, summary, location or keyword">
        </div>
        <div class="filter-bar__field">
            <label for="sector">Sector</label>
            <select id="sector" name="sector">
                <option value="">All sectors</option>
                <option value="" @selected($filters['sector'] === '')>—</option>
                @foreach ($sectors as $sector)
                    <option value="{{ $sector->slug }}" @selected($filters['sector'] === $sector->slug)
                        {{ $sector->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="filter-bar__actions">
            <button type="submit" class="btn btn-mia btn-primary-mia">
                Apply <x-icon name="search" class="icon" />
            </button>
            @if ($filters['q'] !== '' || $filters['status'] !== '' || $filters['sector'] !== '')
                <a class="filter-bar__clear" href="{{ route('admin.opportunities.index') }}">
                    <x-icon name="x" class="icon" /> Clear
                </a>
            @endif
        </div>
    </form>

    <section class="dash-block">
        @if ($opportunities->isEmpty())
            <div class="empty-state empty-state--panel">
                <h3>{{ $counts['all'] === 0 ? 'No opportunities yet' : 'Nothing in this view' }}</h3>
                <p>
                    @if ($counts['all'] === 0)
                        Add the first opportunity to begin showcasing investment options.
                    @elseif ($filters['q'] !== '')
                        No opportunities match “{{ $filters['q'] }}”.
                    @else
                        No opportunities match the selected filters.
                    @endif
                </p>
                @if ($counts['all'] === 0)
                    <a class="btn btn-mia btn-gold-mia" href="{{ route('admin.opportunities.create') }}">
                        Add opportunity <x-icon name="plus" class="icon" />
                    </a>
                @else
                    <a class="btn btn-mia btn-outline-mia" href="{{ route('admin.opportunities.index') }}">Reset filters</a>
                @endif
            </div>
        @else
            <div class="table-responsive">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Sector</th>
                            <th scope="col">Status</th>
                            <th scope="col">Featured</th>
                            <th scope="col">Order</th>
                            <th scope="col"><span class="visually-hidden">Edit</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($opportunities as $opp)
                            <tr>
                                <td>
                                    <a class="dash-table__title" href="{{ route('admin.opportunities.edit', $opp) }}">
                                        {{ $opp->title }}
                                    </a>
                                    <span class="admin-sub">{{ $opp->summary }}</span>
                                </td>
                                <td>
                                    @if ($opp->industry)
                                        <a href="{{ route('admin.sectors.edit', $opp->industry) }}">
                                            {{ $opp->industry->name }}
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-badge status-badge--{{ $opp->status }}">
                                        {{ ucfirst($opp->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($opp->is_featured)
                                        <span class="badge-mia">Featured</span>
                                    @else
                                        <span class="badge-mia--navy">Not featured</span>
                                    @endif
                                </td>
                                <td>{{ $opp->sort_order }}</td>
                                <td class="admin-nowrap">
                                    <a class="textlink" href="{{ route('admin.opportunities.edit', $opp) }}">
                                        Edit <x-icon name="arrow-right" />
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="admin-pagination">
                {{ $opportunities->links() }}
            </div>
        @endif
    </section>
@endsection