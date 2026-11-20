@extends('layouts.public')

@section('description', 'Identification and coordination of statutory licenses, operating permits, trade registrations and renewals — with agency fees published for the permits we process.')

@section('title', 'Business Licensing')

@section('content')
    <x-page-head
        title="Business Licensing"
        lead="Identifying the statutory licenses that apply to your activity, preparing each application and managing renewals." />

    {{-- Intro --}}
    <section class="section section--bg">
        <div class="container container-mia">
            <div class="split">
                <div class="split__media reveal">
                    <div class="media-frame media-frame--4x3">
                        <img src="{{ asset(config('assets.agency.finance.path')) }}" alt="{{ config('assets.agency.finance.alt') }}">
                    </div>
                </div>
                <div class="split__body">
                    <span class="eyebrow">Licensing</span>
                    <h2>The Right Licenses, Identified Before You Operate.</h2>
                    <p class="lead">
                        Registration establishes the entity. Licenses establish the right to carry
                        out specific activities. Missing one stalls operations; the agency maps them
                        up front.
                    </p>
                    <p>
                        We review the intended activity against the authority requirements that
                        apply to it, list every license and permit required, and coordinate each
                        application. Where an activity requires specialist certification, we say so
                        before any fees are paid.
                    </p>
                    <div class="notice-inline">
                        <x-icon name="circle-alert" class="icon" />
                        <p>
                            <strong>Licenses are granted by public authorities.</strong>
                            The agency coordinates applications but does not issue licenses or
                            guarantee approvals.
                        </p>
                    </div>
                    <a class="textlink" href="#permits">
                        See permit pricing <x-icon name="arrow-right" />
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- License categories --}}
    <section class="section section--tint">
        <div class="container container-mia">
            <div class="section-head">
                <span class="eyebrow">Coverage</span>
                <h2>Categories We Coordinate</h2>
                <p class="lead mb-0">The applicable set depends on your activity, premises and scale of operations.</p>
            </div>
            <div class="licence-grid">
                <div class="licence-card">
                    <x-icon name="landmark" class="icon" />
                    <h3>Sector licenses</h3>
                    <p>Activity-specific licenses issued by the sector regulator — the first requirement for regulated industries.</p>
                </div>
                <div class="licence-card">
                    <x-icon name="factory" class="icon" />
                    <h3>Operating permits</h3>
                    <p>Permits covering production, storage, handling or service delivery at a specific site.</p>
                </div>
                <div class="licence-card">
                    <x-icon name="shield-check" class="icon" />
                    <h3>Health &amp; safety</h3>
                    <p>Inspections and certifications tied to premises, equipment and workforce safety.</p>
                </div>
                <div class="licence-card">
                    <x-icon name="globe" class="icon" />
                    <h3>Trade &amp; customs</h3>
                    <p>Import, export and customs registrations where the business trades across borders.</p>
                </div>
                <div class="licence-card">
                    <x-icon name="calendar" class="icon" />
                    <h3>Renewals</h3>
                    <p>Calendar-based renewal management so licenses do not lapse while operations continue.</p>
                </div>
                <div class="licence-card">
                    <x-icon name="file-text" class="icon" />
                    <h3>Amendments</h3>
                    <p>Variations when activity, premises or ownership changes after the license is issued.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Permit catalogue & agency fees --}}
    <section class="section section--bg" id="permits">
        <div class="container container-mia">
            <div class="section-head">
                <span class="eyebrow">Pricing</span>
                <h2>Permits &amp; Agency Fees</h2>
                <p class="lead mb-0">
                    The permits most often requested by investors, with our own service fee
                    stated up front. Applicability is confirmed against your structure, state
                    and activity before any work is billed.
                </p>
            </div>

            @if ($permits->isEmpty())
                <div class="permit-empty">
                    <p class="mb-0">
                        The permit catalogue is being updated. Describe your activity and the
                        desk will confirm the permits and current pricing in writing.
                    </p>
                    <a class="btn btn-mia btn-outline-mia" href="{{ route('contact') }}">
                        Ask the desk <x-icon name="arrow-right" class="icon icon--arrow" />
                    </a>
                </div>
            @else
                <ul class="permit-list">
                    @foreach ($permits as $permit)
                        <li class="permit-row">
                            <div class="permit-row__body">
                                <h3>{{ $permit->name }}</h3>
                                @if ($permit->authority || $permit->turnaround)
                                    <p class="permit-row__meta">
                                        @if ($permit->authority)
                                            <span>{{ $permit->authority }}</span>
                                        @endif
                                        @if ($permit->turnaround)
                                            <span>{{ $permit->turnaround }}</span>
                                        @endif
                                    </p>
                                @endif
                                @if ($permit->summary)
                                    <p class="permit-row__summary">{{ $permit->summary }}</p>
                                @endif
                            </div>

                            <div class="permit-row__fee">
                                @if ($permit->formattedFee())
                                    <span class="permit-row__amount">{{ $permit->formattedFee() }}</span>
                                    <span class="permit-row__label">Agency service fee</span>
                                @else
                                    <span class="permit-row__amount permit-row__amount--quote">On assessment</span>
                                    <span class="permit-row__label">Confirmed in writing first</span>
                                @endif
                                <div class="permit-row__action" style="margin-top: 0.75rem;">
                                    <a class="btn btn-mia btn-gold-mia" style="padding: 0.45rem 1rem; font-size: 0.85rem;"
                                       href="{{ route('contact', ['subject' => 'Request License: ' . $permit->name]) }}">
                                        Request License <x-icon name="arrow-right" class="icon icon--arrow" />
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <p class="opp-note">
                    Fees shown are the agency's service fee for preparing and coordinating the
                    application. Statutory charges are set by the issuing authority and payable
                    separately. Listing a permit does not imply that it applies to your business,
                    and the agency does not influence any authority's decision.
                </p>
            @endif
        </div>
    </section>

    {{-- Application process --}}
    <section class="section section--tint">
        <div class="container container-mia">
            <div class="section-head">
                <span class="eyebrow">Process</span>
                <h2>How a License Application Runs</h2>
            </div>
            <div class="svc-detail">
                <div class="svc-detail__item">
                    <div class="svc-detail__head">
                        <span class="svc-detail__n">01</span>
                        <x-icon name="search" class="icon" />
                        <h3>Requirement mapping</h3>
                    </div>
                    <div class="svc-detail__body">
                        <p>The intended activity is mapped against the licenses, permits and certifications that apply, with the responsible authority named for each.</p>
                    </div>
                </div>
                <div class="svc-detail__item">
                    <div class="svc-detail__head">
                        <span class="svc-detail__n">02</span>
                        <x-icon name="file-text" class="icon" />
                        <h3>Application preparation</h3>
                    </div>
                    <div class="svc-detail__body">
                        <p>Supporting documents — premises evidence, technical descriptions, certifications — are assembled and checked against each authority's checklist.</p>
                    </div>
                </div>
                <div class="svc-detail__item">
                    <div class="svc-detail__head">
                        <span class="svc-detail__n">03</span>
                        <x-icon name="send" class="icon" />
                        <h3>Submission &amp; inspection</h3>
                    </div>
                    <div class="svc-detail__body">
                        <p>Applications are lodged and site inspections coordinated where required, with the investor briefed on what inspectors will check.</p>
                    </div>
                </div>
                <div class="svc-detail__item">
                    <div class="svc-detail__head">
                        <span class="svc-detail__n">04</span>
                        <x-icon name="circle-check-big" class="icon" />
                        <h3>Issue &amp; conditions</h3>
                    </div>
                    <div class="svc-detail__body">
                        <p>Issued licenses are handed over with their conditions summarised, including any reporting or renewal obligations attached to them.</p>
                    </div>
                </div>
                <div class="svc-detail__item">
                    <div class="svc-detail__head">
                        <span class="svc-detail__n">05</span>
                        <x-icon name="calendar" class="icon" />
                        <h3>Renewal management</h3>
                    </div>
                    <div class="svc-detail__body">
                        <p>Expiry dates are tracked and renewals initiated in good time, so operations are not interrupted by a lapsed permit.</p>
                    </div>
                </div>
            </div>
            <p class="opp-note">
                Timelines and statutory fees are set by each authority and confirmed at application
                stage. The agency does not influence authority decisions.
            </p>
        </div>
    </section>

    {{-- CTA --}}
    <section class="cta-band">
        <div class="container container-mia">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-4">
                <div>
                    <h2>Unsure which licenses apply?</h2>
                    <p>Describe your activity and site — the desk will map the requirements before you commit.</p>
                </div>
                <div class="cta-band__actions">
                    <a class="btn btn-mia btn-gold-mia" href="{{ route('contact') }}">
                        Ask the desk <x-icon name="arrow-right" class="icon icon--arrow" />
                    </a>
                    <a class="btn btn-mia btn-outline-light-mia" href="{{ route('registration') }}">Registration services</a>
                </div>
            </div>
        </div>
    </section>
@endsection
