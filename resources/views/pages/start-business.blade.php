@extends('layouts.public')

@section('description', 'A practical guide to establishing a business: structures, documentation, the registration and licensing path, and what happens at each stage.')

@section('title', 'Start a Business')

@section('content')
    <x-page-head
        title="Start a Business"
        lead="A practical guide to establishing a business: structures, documents, the application path and what to expect at each stage." />

    {{-- Introduction --}}
    <section class="section section--bg">
        <div class="container container-mia">
            <div class="split">
                <div class="split__media reveal">
                    <div class="media-frame media-frame--4x3">
                        <img src="{{ asset(config('assets.agency.handshake.path')) }}" alt="{{ config('assets.agency.handshake.alt') }}">
                    </div>
                </div>
                <div class="split__body">
                    <span class="eyebrow">Before you begin</span>
                    <h2>Establishment Is a Sequence, Not a Single Form.</h2>
                    <p class="lead">
                        Most investors complete the path below in stages. The agency keeps each
                        stage documented and confirms requirements before anything is submitted.
                    </p>
                    <p>
                        Requirements depend on the legal structure you choose, your ownership
                        profile and the activity you intend to carry out. Nothing on this page is a
                        substitute for the current instructions of the responsible public
                        authorities, which are confirmed during your engagement.
                    </p>
                    <div class="notice-inline">
                        <x-icon name="circle-alert" class="icon" />
                        <p>
                            <strong>Private agency.</strong> Registration certificates and
                            statutory licenses are issued only by public authorities. The agency
                            prepares and follows up on applications; it does not issue approvals.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Detailed path --}}
    <section class="section section--tint">
        <div class="container container-mia">
            <div class="section-head">
                <span class="eyebrow">The path</span>
                <h2>Five Stages of Establishment</h2>
                <p class="lead mb-0">What happens at each stage, and what we need from you.</p>
            </div>

            <div class="svc-detail">
                <div class="svc-detail__item">
                    <div class="svc-detail__head">
                        <span class="svc-detail__n">01</span>
                        <x-icon name="message-square" class="icon" />
                        <h3>Enquiry &amp; orientation</h3>
                    </div>
                    <div class="svc-detail__body">
                        <p>An advisor reviews your objectives, investor profile and intended activity, and confirms which structures are open to you.</p>
                        <ul class="check-list">
                            <li><x-icon name="circle-check-big" /> Investor type: individual, corporate or joint venture</li>
                            <li><x-icon name="circle-check-big" /> Intended activity and expected scale</li>
                            <li><x-icon name="circle-check-big" /> Ownership proportions and residency considerations</li>
                        </ul>
                    </div>
                </div>

                <div class="svc-detail__item">
                    <div class="svc-detail__head">
                        <span class="svc-detail__n">02</span>
                        <x-icon name="scale" class="icon" />
                        <h3>Structure selection</h3>
                    </div>
                    <div class="svc-detail__body">
                        <p>The legal form is chosen deliberately — it affects liability, ownership rules, licensing and tax treatment.</p>
                        <ul class="check-list">
                            <li><x-icon name="circle-check-big" /> Comparison of eligible structures for your activity</li>
                            <li><x-icon name="circle-check-big" /> Confirmation of ownership-rule implications</li>
                            <li><x-icon name="circle-check-big" /> Name availability check and reservation guidance</li>
                        </ul>
                    </div>
                </div>

                <div class="svc-detail__item">
                    <div class="svc-detail__head">
                        <span class="svc-detail__n">03</span>
                        <x-icon name="file-text" class="icon" />
                        <h3>Documentation</h3>
                    </div>
                    <div class="svc-detail__body">
                        <p>We issue a document checklist for your structure and review every item before submission, so avoidable refusals are caught early.</p>
                        <ul class="check-list">
                            <li><x-icon name="circle-check-big" /> Identity and corporate documents</li>
                            <li><x-icon name="circle-check-big" /> Constitutional documents and resolutions</li>
                            <li><x-icon name="circle-check-big" /> Activity, premises and sector-specific evidence</li>
                        </ul>
                    </div>
                </div>

                <div class="svc-detail__item">
                    <div class="svc-detail__head">
                        <span class="svc-detail__n">04</span>
                        <x-icon name="landmark" class="icon" />
                        <h3>Registration &amp; licensing</h3>
                    </div>
                    <div class="svc-detail__body">
                        <p>Applications are submitted to the responsible authorities, with status tracked and any queries answered promptly.</p>
                        <ul class="check-list">
                            <li><x-icon name="circle-check-big" /> Registration submission and follow-up</li>
                            <li><x-icon name="circle-check-big" /> Sector license and permit applications</li>
                            <li><x-icon name="circle-check-big" /> Communication of every authority decision as issued</li>
                        </ul>
                    </div>
                </div>

                <div class="svc-detail__item">
                    <div class="svc-detail__head">
                        <span class="svc-detail__n">05</span>
                        <x-icon name="briefcase" class="icon" />
                        <h3>Operational readiness</h3>
                    </div>
                    <div class="svc-detail__body">
                        <p>Once approvals are issued, the desk supports the practical steps of opening for business — and stays available afterwards.</p>
                        <ul class="check-list">
                            <li><x-icon name="circle-check-big" /> Bank account and tax registration guidance</li>
                            <li><x-icon name="circle-check-big" /> Utilities, premises and staffing introductions</li>
                            <li><x-icon name="circle-check-big" /> Aftercare for renewals and expansion</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Document checklist --}}
    <section class="section section--bg">
        <div class="container container-mia">
            <div class="section-head">
                <span class="eyebrow">Preparation</span>
                <h2>Typical Document Checklist</h2>
                <p class="lead mb-0">
                    An indicative checklist. The exact list is confirmed for your structure and
                    activity before submission.
                </p>
            </div>
            <div class="checklist-grid">
                <div class="checklist-panel">
                    <span class="mvi-label">Identity &amp; ownership</span>
                    <ul>
                        <li>Passport or national identity documents for all shareholders</li>
                        <li>Proof of address for individuals</li>
                        <li>Corporate documents for corporate shareholders</li>
                    </ul>
                </div>
                <div class="checklist-panel">
                    <span class="mvi-label">Constitution</span>
                    <ul>
                        <li>Proposed company name and alternatives</li>
                        <li>Objects and activity description</li>
                        <li>Shareholding structure and capital details</li>
                    </ul>
                </div>
                <div class="checklist-panel">
                    <span class="mvi-label">Activity &amp; premises</span>
                    <ul>
                        <li>Premises lease or site details, where applicable</li>
                        <li>Sector-specific certifications, where applicable</li>
                        <li>Environmental or planning conditions, where applicable</li>
                    </ul>
                </div>
            </div>
            <p class="opp-note">
                Documents and copies must be current and legible. The agency verifies completeness
                before submission but cannot waive or alter authority requirements.
            </p>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="section section--tint">
        <div class="container container-mia">
            <div class="section-head">
                <span class="eyebrow">Questions</span>
                <h2>Common Questions</h2>
            </div>
            <div class="faq">
                <details class="faq__item">
                    <summary>Can foreigners own a business here?</summary>
                    <p>
                        Ownership rules depend on the activity and structure. Some activities are open
                        to full foreign ownership and others are subject to conditions. The advisory
                        desk confirms the position for your intended activity before you commit.
                    </p>
                </details>
                <details class="faq__item">
                    <summary>How long does registration take?</summary>
                    <p>
                        Timelines vary by authority, structure and activity, and depend on how complete
                        the submitted documents are. Your advisor sets out an indicative schedule at
                        engagement and updates it as the application progresses.
                    </p>
                </details>
                <details class="faq__item">
                    <summary>What does the agency charge?</summary>
                    <p>
                        Fees are quoted in writing for your specific scope — structure, number of
                        licenses and any coordination required. Statutory fees payable to
                        authorities are separate and are itemised for you.
                    </p>
                </details>
                <details class="faq__item">
                    <summary>Does the agency issue registration certificates?</summary>
                    <p>
                        No. The agency is privately operated and does not issue statutory approvals.
                        Certificates and licenses are issued by the responsible public authorities.
                        Our role is preparation, submission and follow-up.
                    </p>
                </details>
                <details class="faq__item">
                    <summary>Can the agency operate remotely?</summary>
                    <p>
                        Most preparation work can be done remotely. Some steps — account opening,
                        certain declarations and site inspections — may require physical presence or
                        notarised documents. Your advisor flags these early.
                    </p>
                </details>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="cta-band">
        <div class="container container-mia">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-4">
                <div>
                    <h2>Ready to begin?</h2>
                    <p>Submit an enquiry with your activity and structure preference — the desk will respond with the applicable path.</p>
                </div>
                <div class="cta-band__actions">
                    <a class="btn btn-mia btn-gold-mia" href="{{ route('contact') }}">
                        Start an enquiry <x-icon name="arrow-right" class="icon icon--arrow" />
                    </a>
                    <a class="btn btn-mia btn-outline-light-mia" href="{{ route('registration') }}">Registration details</a>
                </div>
            </div>
        </div>
    </section>
@endsection
