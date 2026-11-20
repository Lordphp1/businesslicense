@extends('layouts.public')

@section('description', 'Priority economic sectors supported by the agency, with current opportunities listed for each sector.')

@section('title', 'Priority Sectors')

@section('content')
    <x-page-head
        title="Priority Sectors"
        lead="Sectors selected for their contribution to growth, employment and export capacity. Each sector page lists current opportunities." />

    {{-- Priority sectors — editorial rows --}}
    <section class="section section--bg">
        <div class="container container-mia">
            <div class="section-head">
                <span class="eyebrow">Where to invest</span>
                <h2>Sector Priorities</h2>
                <p class="lead mb-0">
                    The agency concentrates facilitation on these sectors, where demand,
                    partner readiness and policy support currently align.
                </p>
            </div>

            <div class="sector-list">
                @foreach ($industries->where('is_priority') as $industry)
                    @php($img = $industry->image())
                    <a class="sector-row" href="{{ route('sectors.show', $industry) }}">
                        <div class="sector-row__media">
                            <div class="media-frame media-frame--3x2">
                                @if ($img)
                                    <img src="{{ asset($img['path']) }}" alt="{{ $img['alt'] }}" loading="lazy">
                                @endif
                            </div>
                        </div>
                        <div class="sector-row__body">
                            <div class="sector-row__head">
                                <span class="sector-row__icon"><x-icon name="{{ $industry->icon ?? 'briefcase' }}" /></span>
                                <span class="sector-row__name">{{ $industry->name }}</span>
                            </div>
                            <p>{{ $industry->summary }}</p>
                            <span class="textlink sector-row__more">
                                View sector <x-icon name="arrow-right" class="icon icon--arrow" />
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Other sectors --}}
    <section class="section section--tint">
        <div class="container container-mia">
            <div class="section-head">
                <span class="eyebrow">Also covered</span>
                <h2>Additional Sectors &amp; Services</h2>
                <p class="lead mb-0">Enquiries in these areas are handled through the same advisory desk.</p>
            </div>
            <div class="sector-grid">
                @foreach ($industries->where('is_priority', false) as $industry)
                    <a class="sector-cell" href="{{ route('sectors.show', $industry) }}">
                        <x-icon name="{{ $industry->icon ?? 'briefcase' }}" />
                        <span class="sector-cell__name">{{ $industry->name }}</span>
                        <p>{{ $industry->summary }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="cta-band">
        <div class="container container-mia">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-4">
                <div>
                    <h2>Assessing a sector?</h2>
                    <p>Our advisory desk shares current market notes and partner briefs with qualified investors.</p>
                </div>
                <div class="cta-band__actions">
                    <a class="btn btn-mia btn-gold-mia" href="{{ route('contact') }}">
                        Request a briefing <x-icon name="arrow-right" class="icon icon--arrow" />
                    </a>
                    <a class="btn btn-mia btn-outline-light-mia" href="{{ route('opportunities.index') }}">View opportunities</a>
                </div>
            </div>
        </div>
    </section>
@endsection
