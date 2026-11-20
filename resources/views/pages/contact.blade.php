@extends('layouts.public')

@section('description', 'Contact the Meridian Investment Agency advisory desk about investment opportunities or establishing a business. Enquiries are reviewed in order of receipt.')

@section('title', 'Contact the Agency')

@section('content')
    <x-page-head
        title="Contact the Agency"
        lead="Enquiries are reviewed in order of receipt by the advisory desk. Contact details are published once activated." />

    <section class="section section--bg">
        <div class="container container-mia">
            <div class="contact-grid">
                {{-- Form --}}
                <div class="contact-form-col">
                    <span class="eyebrow">Investor enquiry</span>
                    <h2>Start an Enquiry</h2>

                    @if (session('success'))
                        <div class="alert alert-mia-success" role="status">
                            <x-icon name="circle-check-big" class="icon" />
                            <div>
                                <strong>{{ session('success') }}</strong>
                                <p class="mb-0">Reference your enquiry in any follow-up correspondence.</p>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.store') }}" class="contact-form" novalidate>
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="c-name" class="form-label-mia">Full name <span class="req" aria-hidden="true">*</span></label>
                                <input id="c-name" name="name" type="text" value="{{ old('name') }}"
                                    class="form-control-mia @error('name') is-invalid @enderror" required>
                                @error('name')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="c-email" class="form-label-mia">Email address <span class="req" aria-hidden="true">*</span></label>
                                <input id="c-email" name="email" type="email" value="{{ old('email') }}"
                                    class="form-control-mia @error('email') is-invalid @enderror" required>
                                @error('email')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="c-phone" class="form-label-mia">Telephone <span class="opt">optional</span></label>
                                <input id="c-phone" name="phone" type="tel" value="{{ old('phone') }}"
                                    class="form-control-mia @error('phone') is-invalid @enderror">
                                @error('phone')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="c-country" class="form-label-mia">Country of residence <span class="opt">optional</span></label>
                                <input id="c-country" name="country" type="text" value="{{ old('country') }}"
                                    class="form-control-mia @error('country') is-invalid @enderror">
                                @error('country')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="c-sector" class="form-label-mia">Sector of interest <span class="opt">optional</span></label>
                                <select id="c-sector" name="industry_id" class="form-control-mia @error('industry_id') is-invalid @enderror">
                                    <option value="">— Not specified —</option>
                                    @foreach ($industries as $industry)
                                        <option value="{{ $industry->id }}" @selected((string) old('industry_id') === (string) $industry->id)>
                                            {{ $industry->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('industry_id')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="c-subject" class="form-label-mia">Subject <span class="opt">optional</span></label>
                                <input id="c-subject" name="subject" type="text" value="{{ old('subject', request('subject')) }}"
                                    class="form-control-mia @error('subject') is-invalid @enderror">
                                @error('subject')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label for="c-message" class="form-label-mia">Your enquiry <span class="req" aria-hidden="true">*</span></label>
                                <textarea id="c-message" name="message" rows="6"
                                    class="form-control-mia @error('message') is-invalid @enderror"
                                    required placeholder="Describe your investment interest, business activity and establishment stage.">{{ old('message') }}</textarea>
                                @error('message')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-mia btn-gold-mia">
                                    Submit enquiry <x-icon name="send" class="icon" />
                                </button>
                                <p class="form-note">
                                    Details are stored only to respond to your enquiry and are handled by
                                    the agency's advisory desk.
                                </p>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Contact info --}}
                <aside class="contact-aside">
                    <div class="contact-aside__block">
                        <span class="eyebrow">Enquiry desk</span>
                        <div class="svc-list svc-list--plain">
                            <div class="svc-row svc-row--static">
                                <x-icon name="map-pin" />
                                <span>
                                    <span class="svc-row__t">Office address</span>
                                    <span class="svc-row__d">To be confirmed and published by the agency.</span>
                                </span>
                            </div>
                            <div class="svc-row svc-row--static">
                                <x-icon name="mail" />
                                <span>
                                    <span class="svc-row__t">Email</span>
                                    <span class="svc-row__d">Pending publication.</span>
                                </span>
                            </div>
                            <div class="svc-row svc-row--static">
                                <x-icon name="phone" />
                                <span>
                                    <span class="svc-row__t">Telephone</span>
                                    <span class="svc-row__d">Lines pending activation.</span>
                                </span>
                            </div>
                            <div class="svc-row svc-row--static">
                                <x-icon name="clock" />
                                <span>
                                    <span class="svc-row__t">Office hours</span>
                                    <span class="svc-row__d">Monday to Friday, 08:30–17:30, by appointment.</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="contact-aside__block">
                        <span class="eyebrow">What happens next</span>
                        <div class="steps-mini">
                            <div class="steps-mini__item"><span>01</span><p>Your enquiry is logged and reviewed by the advisory desk.</p></div>
                            <div class="steps-mini__item"><span>02</span><p>An advisor is assigned to respond with the requirements that apply to you.</p></div>
                            <div class="steps-mini__item"><span>03</span><p>Structured meetings are scheduled for qualified investors on request.</p></div>
                        </div>
                        <p class="contact-aside__note">
                            The agency cannot issue statutory approvals. Registration and licensing
                            decisions rest solely with the responsible public authorities.
                        </p>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
