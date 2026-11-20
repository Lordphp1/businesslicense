@extends('layouts.public')

@section('description', 'Meridian Investment Agency supports local and international investors with market entry advisory, business registration, licensing and aftercare. A privately operated agency.')

@section('content')

    {{-- 1. HERO  --}}
    @php($hero = config('assets.hero.primary'))
    <section class="hero">
        <div class="hero__media">
            <img src="{{ asset($hero['path']) }}" alt="{{ $hero['alt'] }}" fetchpriority="high">
        </div>
        <div class="hero__scrim"></div>
        <div class="container container-mia">
            <div class="hero__content">
                <span class="eyebrow hero__eyebrow">Investment. Opportunity. Growth.</span>
                <h1>A New Destination for Global Business and Investment.</h1>
                <p class="lead">
                    Discover opportunities, establish your business and access the professional
                    support you need to invest and grow — from first enquiry to operations.
                </p>
                <div class="hero__actions">
                    <a class="btn btn-mia btn-gold-mia" href="{{ route('opportunities.index') }}">
                        Explore Investment Opportunities <x-icon name="arrow-right" class="icon icon--arrow" />
                    </a>
                    <a class="btn btn-mia btn-outline-light-mia" href="{{ route('start-business') }}">
                        Start Your Business
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. QUICK-ENTRY BAND  --}}
    <section class="section--tight" style="padding-block: 0">
        <div class="container container-mia">
            <div class="hero-quick">
                <div class="hero-quick__grid">
                    <a class="hero-quick__item" href="{{ route('opportunities.index') }}">
                        <x-icon name="trending-up" />
                        <span class="hero-quick__label">Investment Opportunities</span>
                        <p>Browse the current project pipeline by sector and location.</p>
                    </a>
                    <a class="hero-quick__item" href="{{ route('start-business') }}">
                        <x-icon name="file-text" />
                        <span class="hero-quick__label">Start a Business</span>
                        <p>Follow the establishment process from structure to registration.</p>
                    </a>
                    <a class="hero-quick__item" href="{{ route('services') }}">
                        <x-icon name="users" />
                        <span class="hero-quick__label">Investor Services</span>
                        <p>Onboarding, facilitation, project support and aftercare.</p>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. AGENCY INTRODUCTION (editorial split)  --}}
    <section class="section section--bg">
        <div class="container container-mia">
            <div class="split">
                <div class="split__media reveal">
                    <div class="figure-offset">
                        <div class="media-frame media-frame--4x3">
                            <img src="{{ asset(config('assets.agency.office.path')) }}" alt="{{ config('assets.agency.office.alt') }}" loading="lazy">
                        </div>
                    </div>
                </div>
                <div class="split__body reveal">
                    <span class="eyebrow">The Agency</span>
                    <h2>A Private Partner for Investors Establishing and Growing Here.</h2>
                    <p class="lead">
                        We are a privately operated investment and business development agency.
                        We help local and foreign investors understand the market, choose the right
                        business structure and move through registration and licensing with
                        qualified support at every stage.
                    </p>
                    <p>
                        The agency does not act as a government authority. Statutory certificates
                        and licenses are issued by the responsible public authorities; we prepare,
                        submit and follow up on applications on behalf of investors.
                    </p>
                    <div class="split__facts">
                        <div>
                            <span class="split__fact-n">1:1</span>
                            <span class="split__fact-l">Advisor support</span>
                        </div>
                        <div>
                            <span class="split__fact-n">12</span>
                            <span class="split__fact-l">Priority sectors</span>
                        </div>
                        <div>
                            <span class="split__fact-n">3</span>
                            <span class="split__fact-l">Service channels</span>
                        </div>
                    </div>
                    <a class="textlink mt-4" href="{{ route('about') }}">
                        About the agency <x-icon name="arrow-right" />
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- 4. INVESTMENT OPPORTUNITIES  --}}
    <section class="section section--tint">
        <div class="container container-mia">
            <div class="section-head section-head--row">
                <div>
                    <span class="eyebrow">Pipeline</span>
                    <h2>Investment Opportunities</h2>
                    <p class="lead mb-0">
                        A selection of current projects. Investment figures are provisional and
                        confirmed only at enquiry stage.
                    </p>
                </div>
                <a class="btn btn-mia btn-outline-mia" href="{{ route('opportunities.index') }}">
                    View all opportunities <x-icon name="arrow-right" class="icon icon--arrow" />
                </a>
            </div>

            @if ($featured)
                @php($fi = $featured->image())
                <a class="featured-opp reveal" href="{{ route('opportunities.index') }}" aria-label="Featured opportunity: {{ $featured->title }}">
                    <div class="media-frame">
                        <img src="{{ asset($fi['path']) }}" alt="{{ $fi['alt'] }}" loading="lazy">
                    </div>
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
                @foreach ($moreOpportunities as $opportunity)
                    <a class="opp-row" href="{{ route('opportunities.index') }}">
                        <span class="opp-row__n">0{{ $loop->iteration }}</span>
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
        </div>
    </section>

    {{-- 5. PRIORITY SECTORS (bordered grid, not cards)  --}}
    <section class="section section--bg">
        <div class="container container-mia">
            <div class="section-head">
                <span class="eyebrow">Where to invest</span>
                <h2>Priority Economic Sectors</h2>
                <p class="lead mb-0">
                    Sectors selected for their contribution to growth, employment and
                    export capacity. Each sector page lists current opportunities.
                </p>
            </div>
            <div class="sector-grid reveal">
                @foreach ($industries as $industry)
                    <a class="sector-cell" href="{{ route('sectors.index') }}">
                        <x-icon name="{{ $industry->icon ?? 'briefcase' }}" />
                        <span class="sector-cell__name">{{ $industry->name }}</span>
                        <p>{{ $industry->summary }}</p>
                    </a>
                @endforeach
            </div>
            <div class="mt-4">
                <a class="textlink" href="{{ route('sectors.index') }}">
                    All sectors and services <x-icon name="arrow-right" />
                </a>
            </div>
        </div>
    </section>

    {{-- 6. WHY INVEST HERE (numbered advantages)  --}}
    <section class="section section--tint">
        <div class="container container-mia">
            <div class="split split--reverse">
                <div class="split__body reveal">
                    <span class="eyebrow">The case</span>
                    <h2>Why Investors Choose This Market.</h2>
                    <p class="lead">
                        Positioning points are being finalised with market data. The themes below
                        reflect the agency's current investment promotion priorities.
                    </p>
                    <div class="adv-list mt-4">
                        <div class="adv-item">
                            <div>
                                <h3>Access to regional markets</h3>
                                <p>Ongoing corridor and trade agreements expand the reachable customer base for producers and distributors.</p>
                            </div>
                        </div>
                        <div class="adv-item">
                            <div>
                                <h3>Establishment support end to end</h3>
                                <p>A single agency accompanies the investor from structure selection to registration and licensing follow-up.</p>
                            </div>
                        </div>
                        <div class="adv-item">
                            <div>
                                <h3>Transparent, configurable requirements</h3>
                                <p>Requirements, fees and timelines are published and confirmed per application — no improvised rules.</p>
                            </div>
                        </div>
                        <div class="adv-item">
                            <div>
                                <h3>Investor aftercare</h3>
                                <p>Relationship managers remain available after establishment for expansion, permits and regulatory guidance.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="split__media reveal">
                    <div class="media-frame media-frame--4x3">
                        <img src="{{ asset(config('assets.agency.meeting.path')) }}" alt="{{ config('assets.agency.meeting.alt') }}" loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 7. ESTABLISHMENT PROCESS (5 steps)  --}}
    <section class="section section--bg">
        <div class="container container-mia">
            <div class="section-head">
                <span class="eyebrow">How it works</span>
                <h2>Establishing a Business in Five Steps</h2>
                <p class="lead mb-0">
                    An indicative path for most structures. Exact stages depend on the chosen
                    legal form and activity.
                </p>
            </div>
            <div class="process reveal">
                <div class="process__step">
                    <h3>Enquiry &amp; orientation</h3>
                    <p>Discuss objectives, investor type and intended activity with an advisor.</p>
                </div>
                <div class="process__step">
                    <h3>Structure selection</h3>
                    <p>Choose the legal form and confirm eligibility for the intended ownership.</p>
                </div>
                <div class="process__step">
                    <h3>Documentation</h3>
                    <p>Prepare identity, ownership and activity documents with our checklist.</p>
                </div>
                <div class="process__step">
                    <h3>Registration &amp; licensing</h3>
                    <p>Submit applications to the responsible authorities and track progress.</p>
                </div>
                <div class="process__step">
                    <h3>Operational readiness</h3>
                    <p>Open accounts, connect utilities and commence operations with aftercare.</p>
                </div>
            </div>
            <div class="mt-5 pt-2">
                <a class="btn btn-mia btn-primary-mia" href="{{ route('start-business') }}">
                    Read the full guide <x-icon name="arrow-right" class="icon icon--arrow" />
                </a>
            </div>
        </div>
    </section>

    {{-- 8. INVESTOR SERVICES  --}}
    <section class="section section--tint">
        <div class="container container-mia">
            <div class="split split--reverse">
                <div class="split__body reveal">
                    <span class="eyebrow">Services</span>
                    <h2>One Relationship, Every Stage.</h2>
                    <div class="svc-list mt-4">
                        <a class="svc-row" href="{{ route('services') }}">
                            <x-icon name="users" />
                            <span>
                                <span class="svc-row__t">Investor onboarding</span>
                                <span class="svc-row__d">Enquiry, classification and orientation tailored to investor type.</span>
                            </span>
                            <x-icon name="chevron-right" class="icon icon--chev" />
                        </a>
                        <a class="svc-row" href="{{ route('registration') }}">
                            <x-icon name="file-text" />
                            <span>
                                <span class="svc-row__t">Business establishment assistance</span>
                                <span class="svc-row__d">Structure advice, documentation and registration submission.</span>
                            </span>
                            <x-icon name="chevron-right" class="icon icon--chev" />
                        </a>
                        <a class="svc-row" href="{{ route('licensing') }}">
                            <x-icon name="shield-check" />
                            <span>
                                <span class="svc-row__t">Licensing support</span>
                                <span class="svc-row__d">Applications, renewals and amendments with clear authorities.</span>
                            </span>
                            <x-icon name="chevron-right" class="icon icon--chev" />
                        </a>
                        <a class="svc-row" href="{{ route('services') }}">
                            <x-icon name="activity" />
                            <span>
                                <span class="svc-row__t">Project support &amp; aftercare</span>
                                <span class="svc-row__d">Regulatory guidance and expansion support after establishment.</span>
                            </span>
                            <x-icon name="chevron-right" class="icon icon--chev" />
                        </a>
                    </div>
                </div>
                <div class="split__media reveal">
                    <div class="media-frame media-frame--4x3">
                        <img src="{{ asset(config('assets.agency.finance.path')) }}" alt="{{ config('assets.agency.finance.alt') }}" loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 9. STATEMENT BAND (full-width photo, no fake stats)  --}}
    @php($skyline = config('assets.hero.skyline'))
    <section class="band">
        <div class="band__media">
            <img src="{{ asset($skyline['path']) }}" alt="{{ $skyline['alt'] }}" loading="lazy">
        </div>
        <div class="band__scrim"></div>
        <div class="container container-mia">
            <div class="band__content">
                <span class="eyebrow">Our commitment</span>
                <blockquote>
                    &ldquo;We measure our work in businesses successfully established, not in
                    slogans. Every application receives a named advisor, a documented path
                    and a straight answer.&rdquo;
                    <footer>— Investment Services Charter, {{ config('app.name') }}</footer>
                </blockquote>
                <a class="btn btn-mia btn-outline-light-mia" href="{{ route('contact') }}">
                    Talk to an advisor
                </a>
            </div>
        </div>
    </section>

    {{-- 10. NEWS --}}
    <section class="section section--bg">
        <div class="container container-mia">
            <div class="section-head section-head--row">
                <div>
                    <span class="eyebrow">Newsroom</span>
                    <h2>Latest News &amp; Announcements</h2>
                    <p class="lead mb-0">Briefings, publications and press releases from the agency.</p>
                </div>
                <a class="btn btn-mia btn-outline-mia" href="{{ route('news.index') }}">
                    All news <x-icon name="arrow-right" class="icon icon--arrow" />
                </a>
            </div>

            <div class="row g-5">
                @foreach ($news->take(3) as $post)
                    @php($ni = $post->image())
                    <div class="col-lg-4 {{ $loop->first ? '' : '' }}">
                        <a class="news-feature reveal" href="{{ route('news.index') }}">
                            <div class="media-frame media-frame--3x2">
                                <img src="{{ asset($ni['path']) }}" alt="{{ $ni['alt'] }}" loading="lazy">
                            </div>
                            <span class="news-feature__cat">{{ ucfirst($post->category) }}</span>
                            <h3>{{ $post->title }}</h3>
                            <p>{{ $post->excerpt }}</p>
                            <span class="news-date mt-2">
                                <x-icon name="calendar" /> {{ $post->published_at->format('j F Y') }}
                            </span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 11. CTA BAND --}}
    <section class="cta-band">
        <div class="container container-mia">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-4">
                <div>
                    <h2>Planning to establish a business?</h2>
                    <p>Register an investor account to start a guided application, or contact our advisory desk for orientation first.</p>
                </div>
                <div class="cta-band__actions">
                    <a class="btn btn-mia btn-gold-mia" href="{{ route('login') }}">
                        Create investor account <x-icon name="arrow-right" class="icon icon--arrow" />
                    </a>
                    <a class="btn btn-mia btn-outline-light-mia" href="{{ route('contact') }}">Contact the agency</a>
                </div>
            </div>
        </div>
    </section>

@endsection