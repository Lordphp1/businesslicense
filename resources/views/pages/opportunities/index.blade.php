@extends('layouts.public')

@section('description', 'Browse current investment opportunities in logistics, manufacturing, energy, agribusiness, tourism, technology and healthcare. Indicative terms confirmed at enquiry.')

@section('title', 'Investment Opportunities')

@section('content')
    <x-page-head
        title="Investment Opportunities"
        lead="Browse the current project pipeline. Indicative terms are provisional and confirmed at enquiry stage." />

    {{-- Filter bar --}}
    <section class="section section--tint section--tight">
        <div class="container container-mia">
            <form class="filter-bar" method="GET" action="{{ route('opportunities.index') }}" aria-label="Filter opportunities">
                <div class="filter-bar__field filter-bar__field--grow">
                    <label for="f-q">Keyword</label>
                    <input type="search" id="f-q" name="q" value="{{ $search }}"
                        placeholder="Search by title, summary or location">
                </div>
                <div class="filter-bar__field">
                    <label for="f-sector">Sector</label>
                    <select id="f-sector" name="sector">
                        <option value="">All sectors</option>
                        @foreach ($sectors as $sector)
                            <option value="{{ $sector->slug }}" @selected($activeSector === $sector->slug)>
                                {{ $sector->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-bar__actions">
                    <button type="submit" class="btn btn-mia btn-outline-mia">
                        Apply <x-icon name="search" class="icon" />
                    </button>
                    @if ($search !== '' || $activeSector !== '')
                        <a class="filter-bar__clear" href="{{ route('opportunities.index') }}">
                            <x-icon name="x" class="icon" /> Clear filters
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </section>

    {{-- Results --}}
    <section class="section section--bg">
        <div class="container container-mia">
            <div class="section-head section-head--row">
                <div>
                    <span class="eyebrow">Project pipeline</span>
                    <h2>@if ($search !== '' || $activeSector !== '') Filtered Results @else Current Opportunities @endif</h2>
                    <p class="lead mb-0">
                        {{ $opportunities->count() }} opportunity{{ $opportunities->count() === 1 ? '' : 's' }}
                        @if ($activeSector !== '')
                            in {{ $sectors->firstWhere('slug', $activeSector)?->name ?? 'the selected sector' }}
                        @endif
                        @if ($search !== '')
                            matching “{{ $search }}”
                        @endif
                    </p>
                </div>
            </div>

            @php
                $featured = $opportunities->firstWhere('is_featured');
                $rest = $opportunities->reject(fn ($o) => $o->is_featured)->values();
            @endphp

            @if ($opportunities->isEmpty())
                <div class="empty-state">
                    <x-icon name="search" class="icon icon--lg" />
                    <h3>No opportunities match these filters</h3>
                    <p>
                        Try a different keyword or sector. New projects are added as they are
                        confirmed with partners — or contact the agency with your investment criteria.
                    </p>
                    <a class="btn btn-mia btn-gold-mia" href="{{ route('opportunities.index') }}">
                        Clear all filters
                    </a>
                </div>
            @else
                @if ($featured)
                    <a class="featured-opp" href="{{ route('contact') }}">
                        @if ($featured->image())
                            <div class="media-frame">
                                <img src="{{ asset($featured->image()['path']) }}"
                                    alt="{{ $featured->image()['alt'] }}" loading="lazy">
                            </div>
                        @endif
                        <div class="featured-opp__body">
                            <span class="badge-mia">Featured</span>
                            <h3>{{ $featured->title }}</h3>
                            <p>{{ $featured->summary }}</p>
                            <div class="featured-opp__foot">
                                <span class="news-date">
                                    <x-icon name="map-pin" />
                                    {{ $featured->location }}
                                    @if ($featured->industry)
                                        &nbsp;·&nbsp;{{ $featured->industry->name }}
                                    @endif
                                </span>
                                <span class="opp-row__amt">{{ $featured->investment_min }}</span>
                            </div>
                        </div>
                    </a>
                @endif

                <div class="mt-4">
                    @foreach ($rest as $opportunity)
                        <a class="opp-row" href="{{ route('contact') }}">
                            <span class="opp-row__n">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <span>
                                <span class="opp-row__t">{{ $opportunity->title }}</span>
                                <span class="opp-row__meta">
                                    {{ $opportunity->industry?->name }} · {{ $opportunity->location }}
                                </span>
                            </span>
                            <span class="opp-row__amt">{{ $opportunity->investment_min }}</span>
                        </a>
                    @endforeach
                </div>

                <p class="opp-note">
                    Each listing is a structured summary. Detailed profiles, documents and
                    indicative terms are shared with qualified investors on enquiry.
                </p>
            @endif
        </div>
    </section>

    {{-- CTA --}}
    <section class="cta-band">
        <div class="container container-mia">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-4">
                <div>
                    <h2>Don't see your project profile?</h2>
                    <p>Tell us your sector interest and investment range — we match serious investors with pipeline projects directly.</p>
                </div>
                <div class="cta-band__actions">
                    <a class="btn btn-mia btn-gold-mia" href="{{ route('contact') }}">
                        Register your interest <x-icon name="arrow-right" class="icon icon--arrow" />
                    </a>
                    <a class="btn btn-mia btn-outline-light-mia" href="{{ route('sectors.index') }}">Browse sectors</a>
                </div>
            </div>
        </div>
    </section>
@endsection
