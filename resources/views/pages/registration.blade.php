@extends('layouts.public')

@section('description', 'How business registration is prepared, submitted and completed, and the division of responsibility between the agency, public authorities and the investor.')

@section('title', 'Business Registration')

@section('content')
    <x-page-head
        title="Business Registration"
        lead="How the registration of a business entity is prepared, submitted and completed — and where the agency's role begins and ends." />

    {{-- Intro --}}
    <section class="section section--bg">
        <div class="container container-mia">
            <div class="split split--reverse">
                <div class="split__body">
                    <span class="eyebrow">Registration</span>
                    <h2>Registration Completes When the Authority Issues the Certificate.</h2>
                    <p class="lead">
                        Registration is a formal act between the applicant and the registrar. The
                        agency prepares the file so that the act can proceed without avoidable delay.
                    </p>
                    <p>
                        We assemble the constitutional documents, verify every attachment against the
                        current checklist, submit the application and follow up on queries until a
                        decision is issued. We then explain the decision plainly, including any
                        conditions attached to it.
                    </p>
                    <div class="notice-inline">
                        <x-icon name="circle-alert" class="icon" />
                        <p>
                            <strong>The certificate is issued by the public registrar, not by the agency.</strong>
                            The agency is privately operated and has no power to grant, refuse or
                            alter registration outcomes.
                        </p>
                    </div>
                </div>
                <div class="split__media reveal">
                    <div class="media-frame media-frame--4x3">
                        <img src="{{ asset(config('assets.agency.office.path')) }}" alt="{{ config('assets.agency.office.alt') }}">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Registration stages --}}
    <section class="section section--tint">
        <div class="container container-mia">
            <div class="section-head">
                <span class="eyebrow">Stages</span>
                <h2>From Name Check to Certificate</h2>
            </div>
            <div class="svc-detail">
                <div class="svc-detail__item">
                    <div class="svc-detail__head">
                        <span class="svc-detail__n">01</span>
                        <x-icon name="search" class="icon" />
                        <h3>Name availability</h3>
                    </div>
                    <div class="svc-detail__body">
                        <p>Proposed names are checked against the registrar's records before any documents are drafted, so the file is not built on a name that cannot be reserved.</p>
                    </div>
                </div>
                <div class="svc-detail__item">
                    <div class="svc-detail__head">
                        <span class="svc-detail__n">02</span>
                        <x-icon name="file-text" class="icon" />
                        <h3>Constitutional documents</h3>
                    </div>
                    <div class="svc-detail__body">
                        <p>The constitution, shareholding details and activity description are prepared for your chosen structure and reviewed with you before signature.</p>
                    </div>
                </div>
                <div class="svc-detail__item">
                    <div class="svc-detail__head">
                        <span class="svc-detail__n">03</span>
                        <x-icon name="send" class="icon" />
                        <h3>Submission</h3>
                    </div>
                    <div class="svc-detail__body">
                        <p>The complete file is lodged with the registrar. Every attachment is checked against the checklist first; statutory fees are itemised in advance.</p>
                    </div>
                </div>
                <div class="svc-detail__item">
                    <div class="svc-detail__head">
                        <span class="svc-detail__n">04</span>
                        <x-icon name="message-square" class="icon" />
                        <h3>Queries &amp; follow-up</h3>
                    </div>
                    <div class="svc-detail__body">
                        <p>If the registrar raises queries, they are relayed to you with a plain explanation and a proposed response, and the file is updated promptly.</p>
                    </div>
                </div>
                <div class="svc-detail__item">
                    <div class="svc-detail__head">
                        <span class="svc-detail__n">05</span>
                        <x-icon name="circle-check-big" class="icon" />
                        <h3>Certificate &amp; handover</h3>
                    </div>
                    <div class="svc-detail__body">
                        <p>On approval, the certificate and conditions are handed over with a summary of post-registration obligations, including the licensing steps that follow.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Who does what --}}
    <section class="section section--bg">
        <div class="container container-mia">
            <div class="section-head">
                <span class="eyebrow">Clarity</span>
                <h2>Who Does What</h2>
                <p class="lead mb-0">A clear division of responsibility is part of the service.</p>
            </div>
            <div class="role-grid">
                <div class="role-panel">
                    <span class="mvi-label">The agency</span>
                    <ul>
                        <li>Prepares and checks the application file</li>
                        <li>Submits and follows up with the registrar</li>
                        <li>Explains requirements, queries and decisions</li>
                        <li>Tracks deadlines and renewals after establishment</li>
                    </ul>
                </div>
                <div class="role-panel">
                    <span class="mvi-label">Public authorities</span>
                    <ul>
                        <li>Set the legal requirements for registration</li>
                        <li>Assess the application on its merits</li>
                        <li>Issue, refuse or condition the certificate</li>
                        <li>Set statutory fees and processing rules</li>
                    </ul>
                </div>
                <div class="role-panel">
                    <span class="mvi-label">The investor</span>
                    <ul>
                        <li>Provides accurate and current documents</li>
                        <li>Signs the constitutional documents</li>
                        <li>Pays statutory fees when due</li>
                        <li>Decides on structure and ownership</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="cta-band">
        <div class="container container-mia">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-4">
                <div>
                    <h2>Begin registration</h2>
                    <p>Send your structure preference and shareholder details — the desk will confirm the current checklist.</p>
                </div>
                <div class="cta-band__actions">
                    <a class="btn btn-mia btn-gold-mia" href="{{ route('contact') }}">
                        Start an enquiry <x-icon name="arrow-right" class="icon icon--arrow" />
                    </a>
                    <a class="btn btn-mia btn-outline-light-mia" href="{{ route('licensing') }}">Licensing services</a>
                </div>
            </div>
        </div>
    </section>
@endsection
