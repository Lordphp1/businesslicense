@extends('layouts.public')

@section('title', 'Investor Dashboard')
@section('description', 'Your investor dashboard: enquiry status, profile completion and agency updates.')

@section('content')
    <section class="section section--tint section--tight">
        <div class="container container-mia">
            <nav aria-label="Breadcrumb" class="page-head__crumbs page-head__crumbs--on-tint">
                <a href="{{ route('home') }}">Home</a>
                <x-icon name="chevron-right" />
                <span aria-current="page">Dashboard</span>
            </nav>
        </div>
    </section>

    <section class="section section--bg">
        <div class="container container-mia">
            <div class="dash-grid">
                {{-- Sidebar --}}
                <aside class="dash-nav">
                    <div class="dash-nav__user">
                        <span class="dash-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</span>
                        <div>
                            <span class="dash-nav__name">{{ $user->name }}</span>
                            <span class="dash-nav__email">{{ $user->email }}</span>
                        </div>
                    </div>
                    <nav aria-label="Dashboard">
                        <a class="dash-nav__link is-active" href="{{ route('dashboard') }}">
                            <x-icon name="chart-pie" /> Overview
                        </a>
                        <a class="dash-nav__link" href="{{ route('dashboard.profile.edit') }}">
                            <x-icon name="users" /> Investor profile
                        </a>
                        <a class="dash-nav__link" href="{{ route('contact') }}">
                            <x-icon name="message-square" /> New enquiry
                        </a>
                        <a class="dash-nav__link" href="{{ route('news.index') }}">
                            <x-icon name="book-open" /> News &amp; briefings
                        </a>
                    </nav>
                    <form method="POST" action="{{ route('logout') }}" class="dash-nav__logout">
                        @csrf
                        <button type="submit" class="dash-nav__link dash-nav__link--button">
                            <x-icon name="log-in" /> Sign out
                        </button>
                    </form>
                </aside>

                {{-- Main --}}
                <div class="dash-main">
                    <div class="dash-head">
                        <div>
                            <span class="eyebrow">Overview</span>
                            <h1>Welcome, {{ Str::before($user->name, ' ') }}.</h1>
                            <p class="lead mb-0">Here is the current position of your enquiries and profile.</p>
                        </div>
                        <a class="btn btn-mia btn-outline-mia" href="{{ route('contact') }}">
                            Start an enquiry <x-icon name="arrow-right" class="icon icon--arrow" />
                        </a>
                    </div>

                    @unless ($user->hasCompletedProfile())
                        <div class="dash-prompt">
                            <x-icon name="circle-alert" class="icon" />
                            <div>
                                <strong>Complete your investor profile</strong>
                                <p>
                                    Add your country and investor type so the advisory desk can match
                                    requirements to your situation.
                                </p>
                            </div>
                            <a class="btn btn-mia btn-gold-mia" href="{{ route('dashboard.profile.edit') }}">Complete profile</a>
                        </div>
                    @endunless

                    {{-- Stats --}}
                    <div class="dash-stats">
                        <div class="dash-stat">
                            <span class="dash-stat__n">{{ $statusCounts->get('new', 0) }}</span>
                            <span class="dash-stat__l">New enquiries</span>
                        </div>
                        <div class="dash-stat">
                            <span class="dash-stat__n">{{ $statusCounts->get('assigned', 0) }}</span>
                            <span class="dash-stat__l">Assigned to an advisor</span>
                        </div>
                        <div class="dash-stat">
                            <span class="dash-stat__n">{{ $statusCounts->get('closed', 0) }}</span>
                            <span class="dash-stat__l">Closed</span>
                        </div>
                    </div>

                    {{-- Enquiries --}}
                    <div class="dash-block">
                        <div class="dash-block__head">
                            <h2>Your enquiries</h2>
                            <span class="dash-block__meta">{{ $statusCounts->sum() }} total</span>
                        </div>

                        @if ($enquiries->isEmpty())
                            <div class="empty-state empty-state--panel">
                                <h3>No enquiries yet</h3>
                                <p>
                                    When you submit an enquiry through the site while signed in, it
                                    appears here with its status.
                                </p>
                                <a class="btn btn-mia btn-gold-mia" href="{{ route('contact') }}">Submit your first enquiry</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="dash-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Enquiry</th>
                                            <th scope="col">Sector</th>
                                            <th scope="col">Submitted</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($enquiries as $enquiry)
                                            <tr>
                                                <td>
                                                    <span class="dash-table__title">{{ $enquiry->subject ?: Str::limit($enquiry->message, 54) }}</span>
                                                </td>
                                                <td>{{ $enquiry->industry?->name ?? '—' }}</td>
                                                <td>{{ $enquiry->created_at->format('j M Y') }}</td>
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
                    </div>

                    {{-- Latest briefings --}}
                    @if ($news->isNotEmpty())
                        <div class="dash-block">
                            <div class="dash-block__head">
                                <h2>Agency briefings</h2>
                                <a class="textlink" href="{{ route('news.index') }}">All news <x-icon name="arrow-right" /></a>
                            </div>
                            <div class="dash-news">
                                @foreach ($news as $post)
                                    <a class="dash-news__item" href="{{ route('news.show', $post) }}">
                                        <span class="news-feature__cat">{{ ucfirst($post->category) }}</span>
                                        <span class="dash-news__title">{{ $post->title }}</span>
                                        <span class="news-date">
                                            <x-icon name="calendar" /> {{ $post->published_at->format('j F Y') }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
