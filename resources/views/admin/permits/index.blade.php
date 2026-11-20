@extends('layouts.admin')

@section('title', 'Permits & pricing')
@section('crumb', 'Permits & pricing')

@section('content')
    <div class="admin-page-head">
        <div>
            <span class="eyebrow">Catalogue</span>
            <h1>Permits &amp; pricing</h1>
            <p class="lead mb-0">
                {{ $counts['active'] }} {{ Str::plural('permit', $counts['active']) }} published.
                Changes appear on the public licensing page immediately.
            </p>
        </div>
        <a class="btn btn-mia btn-gold-mia" href="{{ route('admin.permits.create') }}">
            Add permit <x-icon name="file-text" class="icon" />
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
                href="{{ route('admin.permits.index', array_filter(['status' => $value, 'q' => $filters['q']])) }}"
                @if ($filters['status'] === $value) aria-current="true" @endif>
                {{ $status['label'] }}
                <span>{{ $status['count'] }}</span>
            </a>
        @endforeach
    </div>

    <form class="filter-bar filter-bar--panel" method="GET" action="{{ route('admin.permits.index') }}" aria-label="Filter permits">
        @if ($filters['status'] !== '')
            <input type="hidden" name="status" value="{{ $filters['status'] }}">
        @endif
        <div class="filter-bar__field filter-bar__field--grow">
            <label for="q">Search</label>
            <input type="search" id="q" name="q" value="{{ $filters['q'] }}"
                placeholder="Permit name, authority or slug">
        </div>
        <div class="filter-bar__actions">
            <button type="submit" class="btn btn-mia btn-primary-mia">
                Apply <x-icon name="search" class="icon" />
            </button>
            @if ($filters['q'] !== '' || $filters['status'] !== '')
                <a class="filter-bar__clear" href="{{ route('admin.permits.index') }}">
                    <x-icon name="x" class="icon" /> Clear
                </a>
            @endif
        </div>
    </form>

    <section class="dash-block">
        @if ($permits->isEmpty())
            <div class="empty-state empty-state--panel">
                <h3>{{ $counts['all'] === 0 ? 'No permits yet' : 'Nothing in this view' }}</h3>
                <p>
                    @if ($counts['all'] === 0)
                        Add the first permit to publish its pricing on the public licensing page.
                    @elseif ($filters['q'] !== '')
                        No permits match “{{ $filters['q'] }}”.
                    @else
                        No permits match the selected filters.
                    @endif
                </p>
                @if ($counts['all'] === 0)
                    <a class="btn btn-mia btn-gold-mia" href="{{ route('admin.permits.create') }}">
                        Add permit <x-icon name="file-text" class="icon" />
                    </a>
                @else
                    <a class="btn btn-mia btn-outline-mia" href="{{ route('admin.permits.index') }}">Reset filters</a>
                @endif
            </div>
        @else
            <div class="table-responsive">
                <table class="dash-table dash-table--permits">
                    <thead>
                        <tr>
                            <th scope="col">Permit</th>
                            <th scope="col">Authority</th>
                            <th scope="col">Fee</th>
                            <th scope="col">Status</th>
                            <th scope="col">Order</th>
                            <th scope="col"><span class="visually-hidden">Edit</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permits as $permit)
                            <tr>
                                <td>
                                    <a class="dash-table__title" href="{{ route('admin.permits.edit', $permit) }}">
                                        {{ $permit->name }}
                                    </a>
                                    <span class="admin-sub">{{ $permit->slug }}</span>
                                </td>
                                <td>{{ $permit->authority ?: '—' }}</td>
                                <td class="admin-nowrap">
                                    @if ($permit->formattedFee())
                                        {{ $permit->formattedFee() }}
                                    @else
                                        <span class="admin-sub">On assessment</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-badge status-badge--{{ $permit->is_active ? 'active' : 'inactive' }}">
                                        {{ $permit->is_active ? 'Published' : 'Hidden' }}
                                    </span>
                                </td>
                                <td>{{ $permit->sort_order }}</td>
                                <td class="admin-nowrap">
                                    <a class="textlink" href="{{ route('admin.permits.edit', $permit) }}">
                                        Edit <x-icon name="arrow-right" />
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="admin-pagination">
                {{ $permits->links() }}
            </div>
        @endif
    </section>
@endsection
