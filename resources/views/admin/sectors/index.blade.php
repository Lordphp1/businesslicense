@extends('layouts.admin')

@section('title', 'Sectors')
@section('crumb', 'Sectors')

@section('content')
    <div class="admin-page-head">
        <div>
            <span class="eyebrow">Catalogue</span>
            <h1>Sectors</h1>
            <p class="lead mb-0">
                {{ $counts['active'] }} {{ Str::plural('sector', $counts['active']) }} published.
            </p>
        </div>
        <a class="btn btn-mia btn-gold-mia" href="{{ route('admin.sectors.create') }}">
            Add sector <x-icon name="plus" class="icon" />
        </a>
    </div>

    <div class="admin-status-chips">
        @php
            $statusLinks = [
                '' => ['label' => 'All', 'count' => $counts['all']],
                'active' => ['label' => 'Published', 'count' => $counts['active']],
                'inactive' => ['label' => 'Hidden', 'count' => $counts['inactive']],
            ];
        @endphp
        @foreach ($statusLinks as $value => $status)
            <a class="admin-chip {{ $filters['status'] === $value ? 'is-active' : '' }}"
                href="{{ route('admin.sectors.index', array_filter(['status' => $value, 'q' => $filters['q']])) }}"
                @if ($filters['status'] === $value) aria-current="true" @endif>
                {{ $status['label'] }}
                <span>{{ $status['count'] }}</span>
            </a>
        @endforeach
    </div>

    <form class="filter-bar filter-bar--panel" method="GET" action="{{ route('admin.sectors.index') }}" aria-label="Filter sectors">
        @if ($filters['status'] !== '')
            <input type="hidden" name="status" value="{{ $filters['status'] }}">
        @endif
        <div class="filter-bar__field filter-bar__field--grow">
            <label for="q">Search</label>
            <input type="search" id="q" name="q" value="{{ $filters['q'] }}"
                placeholder="Sector name or slug">
        </div>
        <div class="filter-bar__actions">
            <button type="submit" class="btn btn-mia btn-primary-mia">
                Apply <x-icon name="search" class="icon" />
            </button>
            @if ($filters['q'] !== '' || $filters['status'] !== '')
                <a class="filter-bar__clear" href="{{ route('admin.sectors.index') }}">
                    <x-icon name="x" class="icon" /> Clear
                </a>
            @endif
        </div>
    </form>

    <section class="dash-block">
        @if ($industries->isEmpty())
            <div class="empty-state empty-state--panel">
                <h3>{{ $counts['all'] === 0 ? 'No sectors yet' : 'Nothing in this view' }}</h3>
                <p>
                    @if ($counts['all'] === 0)
                        Add the first sector to begin organizing your investment opportunities.
                    @elseif ($filters['q'] !== '')
                        No sectors match “{{ $filters['q'] }}”.
                    @else
                        No sectors match the selected filters.
                    @endif
                </p>
                @if ($counts['all'] === 0)
                    <a class="btn btn-mia btn-gold-mia" href="{{ route('admin.sectors.create') }}">
                        Add sector <x-icon name="plus" class="icon" />
                    </a>
                @else
                    <a class="btn btn-mia btn-outline-mia" href="{{ route('admin.sectors.index') }}">Reset filters</a>
                @endif
            </div>
        @else
            <div class="table-responsive">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th scope="col">Sector</th>
                            <th scope="col">Icon</th>
                            <th scope="col">Summary</th>
                            <th scope="col">Status</th>
                            <th scope="col">Order</th>
                            <th scope="col"><span class="visually-hidden">Edit</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($industries as $industry)
                            <tr>
                                <td>
                                    <a class="dash-table__title" href="{{ route('admin.sectors.edit', $industry) }}">
                                        {{ $industry->name }}
                                    </a>
                                    <span class="admin-sub">{{ $industry->slug }}</span>
                                </td>
                                <td>
                                    @if ($industry->icon)
                                        <x-icon name="{{ $industry->icon }}" class="icon" width="16" height="16" />
                                    @endif
                                </td>
                                <td>
                                    @if ($industry->summary)
                                        <p class="admin-sub__small">{{ $industry->summary }}</p>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-badge status-badge--{{ $industry->is_active ? 'active' : 'inactive' }}">
                                        {{ $industry->is_active ? 'Published' : 'Hidden' }}
                                    </span>
                                </td>
                                <td>{{ $industry->sort_order }}</td>
                                <td class="admin-nowrap">
                                    <a class="textlink" href="{{ route('admin.sectors.edit', $industry) }}">
                                        Edit <x-icon name="arrow-right" />
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="admin-pagination">
                {{ $industries->links() }}
            </div>
        @endif
    </section>
@endsection