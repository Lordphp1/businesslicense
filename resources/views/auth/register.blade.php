@extends('layouts.public')

@section('title', 'Create an Investor Account')
@section('description', 'Create an investor account to track your enquiries with the Meridian Investment Agency and keep your investor profile current.')

@section('content')
    <section class="auth-shell">
        <div class="container container-mia">
            <div class="auth-grid auth-grid--wide">
                {{-- Brand panel --}}
                <div class="auth-panel">
                    <span class="eyebrow eyebrow--light">Investor portal</span>
                    <h1>Open an investor account.</h1>
                    <p class="auth-panel__lead">
                        An account keeps your enquiries and profile in one place. It does not
                        create a business, grant any approval or replace the advisory desk.
                    </p>
                    <div class="auth-list">
                        <div class="auth-list__item">
                            <x-icon name="activity" class="icon" />
                            <div>
                                <span class="auth-list__t">Track enquiries</span>
                                <span class="auth-list__d">See the status of every enquiry you submit through the site.</span>
                            </div>
                        </div>
                        <div class="auth-list__item">
                            <x-icon name="users" class="icon" />
                            <div>
                                <span class="auth-list__t">Save your investor profile</span>
                                <span class="auth-list__d">Country, company and sector interest stay ready for the advisory desk.</span>
                            </div>
                        </div>
                    </div>
                    <p class="auth-panel__foot">
                        The agency is privately operated. An account is not a license, registration
                        or government credential of any kind.
                    </p>
                </div>

                {{-- Registration form --}}
                <div class="auth-card">
                    <span class="eyebrow">Registration</span>
                    <h2>Create your account</h2>

                    <form method="POST" action="{{ route('register.store') }}" class="auth-form" novalidate>
                        @csrf
                        <div class="auth-row">
                            <div class="auth-field">
                                <label for="reg-name" class="form-label-mia">Full name <span class="req" aria-hidden="true">*</span></label>
                                <input id="reg-name" name="name" type="text" autocomplete="name"
                                    value="{{ old('name') }}" required
                                    class="form-control-mia @error('name') is-invalid @enderror">
                                @error('name')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="auth-field">
                                <label for="reg-email" class="form-label-mia">Email address <span class="req" aria-hidden="true">*</span></label>
                                <input id="reg-email" name="email" type="email" autocomplete="email"
                                    value="{{ old('email') }}" required
                                    class="form-control-mia @error('email') is-invalid @enderror">
                                @error('email')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="auth-row">
                            <div class="auth-field">
                                <label for="reg-company" class="form-label-mia">Company <span class="opt">optional</span></label>
                                <input id="reg-company" name="company" type="text" autocomplete="organization"
                                    value="{{ old('company') }}"
                                    class="form-control-mia @error('company') is-invalid @enderror">
                                @error('company')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="auth-field">
                                <label for="reg-country" class="form-label-mia">Country <span class="opt">optional</span></label>
                                <input id="reg-country" name="country" type="text" autocomplete="country-name"
                                    value="{{ old('country') }}"
                                    class="form-control-mia @error('country') is-invalid @enderror">
                                @error('country')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="auth-row">
                            <div class="auth-field">
                                <label for="reg-phone" class="form-label-mia">Telephone <span class="opt">optional</span></label>
                                <input id="reg-phone" name="phone" type="tel" autocomplete="tel"
                                    value="{{ old('phone') }}"
                                    class="form-control-mia @error('phone') is-invalid @enderror">
                                @error('phone')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="auth-field">
                                <label for="reg-type" class="form-label-mia">Investor type <span class="opt">optional</span></label>
                                <select id="reg-type" name="investor_type"
                                    class="form-control-mia @error('investor_type') is-invalid @enderror">
                                    <option value="">— Select —</option>
                                    <option value="individual" @selected(old('investor_type') === 'individual')>Individual investor</option>
                                    <option value="company" @selected(old('investor_type') === 'company')>Company</option>
                                    <option value="fund" @selected(old('investor_type') === 'fund')>Fund / institutional</option>
                                    <option value="advisor" @selected(old('investor_type') === 'advisor')>Advisor / intermediary</option>
                                </select>
                                @error('investor_type')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="auth-row">
                            <div class="auth-field">
                                <label for="reg-password" class="form-label-mia">Password <span class="req" aria-hidden="true">*</span></label>
                                <input id="reg-password" name="password" type="password" autocomplete="new-password" required
                                    class="form-control-mia @error('password') is-invalid @enderror">
                                <p class="field-hint">At least 10 characters with letters and numbers.</p>
                                @error('password')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="auth-field">
                                <label for="reg-password-confirm" class="form-label-mia">Confirm password <span class="req" aria-hidden="true">*</span></label>
                                <input id="reg-password-confirm" name="password_confirmation" type="password"
                                    autocomplete="new-password" required class="form-control-mia">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-mia btn-gold-mia w-100 mt-2">
                            Create account <x-icon name="user-plus" class="icon" />
                        </button>
                    </form>

                    <p class="auth-switch">
                        Already have an account? <a href="{{ route('login') }}">Sign in</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
