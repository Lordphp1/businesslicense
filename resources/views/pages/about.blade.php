@extends('layouts.public')

@section('description', 'Who we are: a privately operated investment and business development agency. Mission, mandate, strategic objectives and organisational structure.')

@section('title', 'About the Agency')

@section('content')
    <x-page-head
        title="About the Agency"
        lead="A privately operated investment and business development agency supporting local and international investors." />

    {{-- Agency introduction --}}
    <section class="section section--bg">
        <div class="container container-mia">
            <div class="split">
                <div class="split__media">
                    <div class="figure-offset">
                        <div class="media-frame media-frame--4x3">
                            <img src="{{ asset(config('assets.agency.building.path')) }}" alt="{{ config('assets.agency.building.alt') }}" loading="lazy">
                        </div>
                    </div>
                </div>
                <div class="split__body">
                    <span class="eyebrow">Who we are</span>
                    <h2>Established to Make Investment Easier to Navigate.</h2>
                    <p class="lead">
                        {{ config('app.name') }} was created to give investors a single, accountable
                        point of contact for establishing and growing a business.
                    </p>
                    <p>
                        We work with local and foreign investors at every stage: understanding the
                        market, selecting the right business structure, preparing documentation,
                        submitting registration and licensing applications, and supporting
                        operations after establishment.
                    </p>
                    <p>
                        <strong>We are a private agency, not a government authority.</strong>
                        Certificates of incorporation and statutory licenses are issued solely by
                        the responsible public authorities. Our role is to prepare, submit and
                        follow up on applications, and to make the requirements clear before you
                        commit.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Mission, vision, mandate --}}
    <section class="section section--tint" id="mission">
        <div class="container container-mia">
            <div class="section-head">
                <span class="eyebrow">Direction</span>
                <h2>Mission, Vision &amp; Mandate</h2>
                <p class="lead mb-0">Provisional statements pending ratification by the agency's board.</p>
            </div>
            <div class="mvi-grid">
                <div class="mvi-item">
                    <span class="mvi-label">Mission</span>
                    <p>
                        To attract, support and retain productive investment by providing investors
                        with clear guidance, dependable establishment services and honest follow-up
                        at every stage of the business lifecycle.
                    </p>
                </div>
                <div class="mvi-item">
                    <span class="mvi-label">Vision</span>
                    <p>
                        To be the first point of call for investors entering this market — known for
                        transparency, responsiveness and measurable investor outcomes.
                    </p>
                </div>
                <div class="mvi-item">
                    <span class="mvi-label">Mandate</span>
                    <p>
                        Investment promotion, investor onboarding, business establishment
                        assistance, licensing support where authorized, and investor aftercare.
                        The mandate is administrative and advisory; statutory approvals remain with
                        government authorities.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Strategic objectives --}}
    <section class="section section--bg">
        <div class="container container-mia">
            <div class="section-head section-head--row">
                <div>
                    <span class="eyebrow">Priorities</span>
                    <h2>Strategic Objectives</h2>
                    <p class="lead mb-0">The objectives below guide our service planning for the current cycle.</p>
                </div>
            </div>
            <div class="adv-list adv-list--wide">
                <div class="adv-item">
                    <div>
                        <h3>Shorten the establishment journey</h3>
                        <p>Publish requirements, document checklists and expected stages so investors can plan with confidence.</p>
                    </div>
                </div>
                <div class="adv-item">
                    <div>
                        <h3>Make requirements verifiable</h3>
                        <p>Keep fees, timelines and eligibility configurable and reviewed, with authorities identified for every statutory step.</p>
                    </div>
                </div>
                <div class="adv-item">
                    <div>
                        <h3>Deepen sector engagement</h3>
                        <p>Maintain current opportunity and sector information across the priority economic sectors.</p>
                    </div>
                </div>
                <div class="adv-item">
                    <div>
                        <h3>Institutionalise aftercare</h3>
                        <p>Support established investors with expansion, permit renewals and regulatory guidance.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Leadership & organisation (placeholders) --}}
    <section class="section section--tint">
        <div class="container container-mia">
            <div class="split split--reverse">
                <div class="split__body">
                    <span class="eyebrow">Structure</span>
                    <h2>Leadership &amp; Organisation</h2>
                    <p class="lead">
                        The agency's leadership team and organisational chart will be published here
                        once appointments are confirmed. No names or credentials are shown until
                        verified.
                    </p>
                    <div class="svc-list mt-4">
                        <div class="svc-row">
                            <x-icon name="landmark" />
                            <span>
                                <span class="svc-row__t">Office of the Director</span>
                                <span class="svc-row__d">Executive oversight and public representation.</span>
                            </span>
                        </div>
                        <div class="svc-row">
                            <x-icon name="briefcase" />
                            <span>
                                <span class="svc-row__t">Investment Services</span>
                                <span class="svc-row__d">Enquiry handling, onboarding and facilitation.</span>
                            </span>
                        </div>
                        <div class="svc-row">
                            <x-icon name="file-text" />
                            <span>
                                <span class="svc-row__t">Registration &amp; Licensing</span>
                                <span class="svc-row__d">Application preparation, submission and follow-up.</span>
                            </span>
                        </div>
                        <div class="svc-row">
                            <x-icon name="users" />
                            <span>
                                <span class="svc-row__t">Investor Aftercare</span>
                                <span class="svc-row__d">Post-establishment support and expansion guidance.</span>
                            </span>
                        </div>
                    </div>
                    <p class="mt-4" style="font-size: var(--fs-300); color: var(--c-text-muted);">
                        Function descriptions are indicative and will be updated as the organisation is staffed.
                    </p>
                </div>
                <div class="split__media">
                    <div class="media-frame media-frame--4x3">
                        <img src="{{ asset(config('assets.agency.team.path')) }}" alt="{{ config('assets.agency.team.alt') }}" loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="cta-band">
        <div class="container container-mia">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-4">
                <div>
                    <h2>Speak with the agency</h2>
                    <p>Enquiries are reviewed by our advisory desk and answered in order of receipt.</p>
                </div>
                <div class="cta-band__actions">
                    <a class="btn btn-mia btn-gold-mia" href="{{ route('contact') }}">
                        Contact the agency <x-icon name="arrow-right" class="icon icon--arrow" />
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
