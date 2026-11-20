@extends('layouts.public')

@section('title', $industry->name)
@section('description', $industry->summary)

@section('content')
    <x-page-head
        title="{{ $industry->name }}"
        lead="{{ $industry->summary }}" />

    {{-- Sector overview --}}
    <section class="section section--bg">
        <div class="container container-mia">
            <div class="split">
                <div class="split__media reveal">
                    @php($img = $industry->image())
                    @if ($img)
                        <div class="media-frame media-frame--4x3">
                            <img src="{{ asset($img['path']) }}" alt="{{ $img['alt'] }}">
                        </div>
                    @endif
                </div>
                <div class="split__body">
                    <span class="eyebrow">Sector profile</span>
                    <h2>{{ $industry->name }}</h2>
                    <p class="lead">{{ $industry->summary }}</p>
                    <p>
                        This sector page collects the agency's current facilitation activity:
                        projects in the pipeline, the type of establishment support available,
                        and the public authorities involved in statutory approvals.
                    </p>
                    <div class="svc-list mt-4">
                        <div class="svc-row svc-row--static">
                            <x-icon name="file-text" />
                            <span>
                                <span class="svc-row__t">Establishment support</span>
                                <span class="svc-row__d">Registration, licensing and documentation assistance for businesses in this sector.</span>
                            </span>
                        </div>
                        <div class="svc-row svc-row--static">
                            <x-icon name="users" />
                            <span>
                                <span class="svc-row__t">Investor matching</span>
                                <span class="svc-row__d">Introduction to sector partners and pipeline projects on enquiry.</span>
                            </span>
                        </div>
                        <div class="svc-row svc-row--static">
                            <x-icon name="shield-check" />
                            <span>
                                <span class="svc-row__t">Statutory clarity</span>
                                <span class="svc-row__d">Requirements are confirmed with the responsible public authorities before submission.</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Sector opportunities --}}
    <section class="section section--tint" id="opportunities">
        <div class="container container-mia">
            <div class="section-head section-head--row">
                <div>
                    <span class="eyebrow">Pipeline</span>
                    <h2>Opportunities in {{ Str::before($industry->name, ' &') }}</h2>
                </div>
                <a class="btn btn-mia btn-outline-mia" href="{{ route('opportunities.index', ['sector' => $industry->slug]) }}">
                    All opportunities <x-icon name="arrow-right" class="icon icon--arrow" />
                </a>
            </div>

            @if ($opportunities->isEmpty())
                <div class="empty-state">
                    <h3>No open opportunities right now</h3>
                    <p>
                        Nothing is published in this sector at the moment. New projects are listed as
                        partner engagements are confirmed — contact the desk to register interest.
                    </p>
                    <a class="btn btn-mia btn-gold-mia" href="{{ route('contact') }}">
                        Register interest <x-icon name="arrow-right" class="icon icon--arrow" />
                    </a>
                </div>
            @else
                <div>
                    @foreach ($opportunities as $opportunity)
                        <a class="opp-row" href="{{ route('contact') }}">
                            <span class="opp-row__n">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <span>
                                <span class="opp-row__t">{{ $opportunity->title }}</span>
                                <span class="opp-row__meta">{{ $opportunity->location }}</span>
                            </span>
                            <span class="opp-row__amt">{{ $opportunity->investment_min }}</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- Sibling sectors --}}
    <section class="section section--bg">
        <div class="container container-mia">
            <div class="section-head">
                <span class="eyebrow">Continue exploring</span>
                <h2>Other Sectors</h2>
            </div>
            <div class="sector-grid sector-grid--compact">
                @foreach ($siblings as $sibling)
                    <a class="sector-cell" href="{{ route('sectors.show', ['industry' => $sibling->slug]) }}">
                        <x-icon name="{{ $sibling->icon ?? 'briefcase' }}" />
                        <span class="sector-cell__name">{{ $sibling->name }}</span>
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
                    <h2>Establish a business in this sector</h2>
                    <p>The agency supports registration, licensing and setup from first enquiry to operations.</p>
                </div>
                <div class="cta-band__actions">
                    <a class="btn btn-mia btn-gold-mia" href="{{ route('contact') }}">
                        Start an enquiry <x-icon name="arrow-right" class="icon icon--arrow" />
                    </a>
                    <a class="btn btn-mia btn-outline-light-mia" href="{{ route('start-business') }}">How it works</a>
                </div>
            </div>
        </div>
    </section>
@endsection
