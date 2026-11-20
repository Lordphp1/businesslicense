@extends('layouts.admin')

@section('title', 'News')
@section('crumb', 'News')

@section('content')
    <div class="admin-page-head">
        <div>
            <span class="eyebrow">Catalogue</span>
            <h1>News & Publications</h1>
            <p class="lead mb-0">
                {{ $counts['published'] }} {{ Str::plural('post', $counts['published']) }} published.
            </p>
        </div>
        <a class="btn btn-mia btn-gold-mia" href="{{ route('admin.news.create') }}">
            Add post <x-icon name="plus" class="icon" />
        </a>
    </div>

    <div class="admin-status-chips">
        @php
            $statusLinks = [
                '' => ['label' => 'All', 'count' => $counts['all']],
                'published' => ['label' => 'Published', 'count' => $counts['published']],
                'featured' => ['label' => 'Featured', 'count' => $counts['featured']],
            ];
        @endphp
        @foreach ($statusLinks as $value => $status)
            <a class="admin-chip {{ $filters['status'] === $value ? 'is-active' : '' }}"
                href="{{ route('admin.news.index', array_filter(['status' => $value, 'featured' => $filters['featured'], 'q' => $filters['q']])) }}"
                @if ($filters['status'] === $value) aria-current="true" @endif>
                {{ $status['label'] }}
                <span>{{ $status['count'] }}</span>
            </a>
        @endforeach
    </div>

    <form class="filter-bar filter-bar--panel" method="GET" action="{{ route('admin.news.index') }}" aria-label="Filter news">
        @if ($filters['status'] !== '')
            <input type="hidden" name="status" value="{{ $filters['status'] }}">
        @endif
        @if ($filters['featured'] !== '')
            <input type="hidden" name="featured" value="{{ $filters['featured'] }}">
        @endif
        <div class="filter-bar__field filter-bar__field--grow">
            <label for="q">Search</label>
            <input type="search" id="q" name="q" value="{{ $filters['q'] }}"
                placeholder="Title, excerpt, body or category">
        </div>
        <div class="filter-bar__actions">
            <button type="submit" class="btn btn-mia btn-primary-mia">
                Apply <x-icon name="search" class="icon" />
            </button>
            @if ($filters['q'] !== '' || $filters['featured'] !== '')
                <a class="filter-bar__clear" href="{{ route('admin.news.index') }}">
                    <x-icon name="x" class="icon" /> Clear
                </a>
            @endif
        </div>
    </form>

    <section class="dash-block">
        @if ($posts->isEmpty())
            <div class="empty-state empty-state--panel">
                <h3>{{ $counts['all'] === 0 ? 'No posts yet' : 'Nothing in this view' }}</h3>
                <p>
                    @if ($counts['all'] === 0)
                        Add the first news post to begin sharing agency updates.
                    @elseif ($filters['q'] !== '')
                        No posts match “{{ $filters['q'] }}”.
                    @else
                        No posts match the selected filters.
                    @endif
                </p>
                @if ($counts['all'] === 0)
                    <a class="btn btn-mia btn-gold-mia" href="{{ route('admin.news.create') }}">
                        Add post <x-icon name="plus" class="icon" />
                    </a>
                @else
                    <a class="btn btn-mia btn-outline-mia" href="{{ route('admin.news.index') }}">Reset filters</a>
                @endif
            </div>
        @else
            <div class="table-responsive">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Category</th>
                            <th scope="col">Featured</th>
                            <th scope="col">Published</th>
                            <th scope="col">Order</th>
                            <th scope="col"><span class="visually-hidden">Edit</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td>
                                    <a class="dash-table__title" href="{{ route('admin.news.edit', $post) }}">
                                        {{ $post->title }}
                                    </a>
                                    <span class="admin-sub">{{ Str::limit($post->excerpt, 60) }}</span>
                                </td>
                                <td>
                                    {{ ucfirst($post->category) }}
                                </td>
                                <td>
                                    @if ($post->is_featured)
                                        <span class="badge-mia">Featured</span>
                                    @else
                                        <span class="badge-mia--navy">Not featured</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($post->published_at)
                                        {{ $post->published_at->format('j M Y') }}
                                    @else
                                        <span class="admin-sub">Unpublished</span>
                                    @endif
                                </td>
                                <td>{{ $post->sort_order }}</td>
                                <td class="admin-nowrap">
                                    <a class="textlink" href="{{ route('admin.news.edit', $post) }}">
                                        Edit <x-icon name="arrow-right" />
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="admin-pagination">
                {{ $posts->links() }}
            </div>
        @endif
    </section>
@endsection