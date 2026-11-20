@extends('layouts.public')

@section('description', 'Investor services across the business lifecycle: market entry advisory, business establishment, licensing and permits, aftercare and investment facilitation.')

@section('title', 'Investor Services')

@section('content')
    <x-page-head
        title="Investor Services"
        lead="Advisory and facilitation services across the business lifecycle — from first market assessment to post-establishment support." />

    {{-- Introduction --}}
    <section class="section section--bg">
        <div class="container container-mia">
            <div class="split">
                <div class="split__media reveal">
                    <div class="media-frame media-frame--4x3">
                        <img src="{{ asset(config('assets.agency.meeting.path')) }}" alt="{{ config('assets.agency.meeting.alt') }}">
                    </div>
                </div>
                <div class="split__body">
                    <span class="eyebrow">How we work</span>
                    <h2>One Desk, Every Stage.</h2>
                    <p class="lead">
                        Each engagement is assigned to an advisory desk that stays with the investor
                        from enquiry to operations.
                    </p>
                    <p>
                        Our work is administrative and advisory. We prepare, submit and follow up on
                        applications, and we tell investors plainly what depends on public authorities
                        and what depends on them.
                    </p>
                    <p>
                        <strong>We are a private agency, not a government authority.</strong>
                        Statutory approvals and certificates are issued by the responsible public
                        bodies. We do not issue approvals, and we do not represent that we can.
                    </p>
                    <a class="textlink mt-2" href="{{ route('contact') }}">
                        Discuss your requirements <x-icon name="arrow-right" />
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Service lines --}}
    <section class="section section--tint">
        <div class="container container-mia">
            <div class="section-head">
                <span class="eyebrow">Service lines</span>
                <h2>What the Agency Does</h2>
                <p class="lead mb-0">Five service lines, delivered directly or coordinated with vetted professional partners.</p>
            </div>

            <div class="svc-detail">
                <div class="svc-detail__item">
                    <div class="svc-detail__head">
                        <span class="svc-detail__n">01</span>
                        <x-icon name="chart-column" class="icon" />
                        <h3>Market entry advisory</h3>
                    </div>
                    <div class="svc-detail__body">
                        <p>Structured orientation for investors assessing the market: sector context, competitive landscape and practical entry considerations.</p>
                        <ul class="check-list">
                            <li><x-icon name="circle-check-big" /> Sector briefings and market notes</li>
                            <li><x-icon name="circle-check-big" /> Business model and structure discussion</li>
                            <li><x-icon name="circle-check-big" /> Introductory meetings with relevant partners</li>
                        </ul>
                    </div>
                </div>

                <div class="svc-detail__item">
                    <div class="svc-detail__head">
                        <span class="svc-detail__n">02</span>
                        <x-icon name="building-2" class="icon" />
                        <h3>Business establishment</h3>
                    </div>
                    <div class="svc-detail__body">
                        <p>End-to-end support for setting up the legal entity, from structure selection to the completion of registration formalities.</p>
                        <ul class="check-list">
                            <li><x-icon name="circle-check-big" /> Entity type selection and name reservation guidance</li>
                            <li><x-icon name="circle-check-big" /> Document preparation and checklist management</li>
                            <li><x-icon name="circle-check-big" /> Application submission and follow-up with authorities</li>
                        </ul>
                    </div>
                </div>

                <div class="svc-detail__item">
                    <div class="svc-detail__head">
                        <span class="svc-detail__n">03</span>
                        <x-icon name="file-text" class="icon" />
                        <h3>Licensing &amp; permits</h3>
                    </div>
                    <div class="svc-detail__body">
                        <p>Identification of the statutory licenses that apply to the intended activity, and coordination of each application.</p>
                        <ul class="check-list">
                            <li><x-icon name="circle-check-big" /> Compliance mapping for the planned activity</li>
                            <li><x-icon name="circle-check-big" /> Application preparation and submission</li>
                            <li><x-icon name="circle-check-big" /> Renewal calendar and status tracking</li>
                        </ul>
                    </div>
                </div>

                <div class="svc-detail__item">
                    <div class="svc-detail__head">
                        <span class="svc-detail__n">04</span>
                        <x-icon name="users" class="icon" />
                        <h3>Investor aftercare</h3>
                    </div>
                    <div class="svc-detail__body">
                        <p>Continued support after establishment, so retained investors can expand without re-learning the system.</p>
                        <ul class="check-list">
                            <li><x-icon name="circle-check-big" /> Expansion and additional-facility guidance</li>
                            <li><x-icon name="circle-check-big" /> Permit renewal reminders and assistance</li>
                            <li><x-icon name="circle-check-big" /> Escalation of operational and regulatory issues</li>
                        </ul>
                    </div>
                </div>

                <div class="svc-detail__item">
                    <div class="svc-detail__head">
                        <span class="svc-detail__n">05</span>
                        <x-icon name="trending-up" class="icon" />
                        <h3>Investment facilitation</h3>
                    </div>
                    <div class="svc-detail__body">
                        <p>Matching qualified investors with pipeline projects and coordinating the introductions and preliminary documents.</p>
                        <ul class="check-list">
                            <li><x-icon name="circle-check-big" /> Opportunity profiles matched to investor criteria</li>
                            <li><x-icon name="circle-check-big" /> Introductions to project sponsors</li>
                            <li><x-icon name="circle-check-big" /> Coordination of site visits and due-diligence requests</li>
                        </ul>
                    </div>
                </div>
            </div>

            <p class="opp-note">
                Fees, scope and turnaround are confirmed in writing before work begins. Services
                requiring statutory approvals are submitted to, and decided by, the responsible
                public authorities.
            </p>
        </div>
    </section>

    {{-- CTA --}}
    <section class="cta-band">
        <div class="container container-mia">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-4">
                <div>
                    <h2>Need a scoped proposal?</h2>
                    <p>Tell us your activity and structure preference — the desk will respond with requirements and a work plan.</p>
                </div>
                <div class="cta-band__actions">
                    <a class="btn btn-mia btn-gold-mia" href="{{ route('contact') }}">
                        Request a proposal <x-icon name="arrow-right" class="icon icon--arrow" />
                    </a>
                    <a class="btn btn-mia btn-outline-light-mia" href="{{ route('start-business') }}">Start a business</a>
                </div>
            </div>
        </div>
    </section>
@endsection
