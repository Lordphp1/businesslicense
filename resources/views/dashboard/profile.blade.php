@extends('layouts.public')

@section('title', 'Investor Profile')
@section('description', 'Manage your investor profile: contact details, company, country and investor type.')

@section('content')
    <section class="section section--tint section--tight">
        <div class="container container-mia">
            <nav aria-label="Breadcrumb" class="page-head__crumbs page-head__crumbs--on-tint">
                <a href="{{ route('home') }}">Home</a>
                <x-icon name="chevron-right" />
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <x-icon name="chevron-right" />
                <span aria-current="page">Investor profile</span>
            </nav>
        </div>
    </section>

    <section class="section section--bg">
        <div class="container container-mia">
            <div class="dash-grid">
                {{-- Sidebar --}}
                <aside class="dash-nav">
                    <div class="dash-nav__user">
                        <span class="dash-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</span>
                        <div>
                            <span class="dash-nav__name">{{ $user->name }}</span>
                            <span class="dash-nav__email">{{ $user->email }}</span>
                        </div>
                    </div>
                    <nav aria-label="Dashboard">
                        <a class="dash-nav__link" href="{{ route('dashboard') }}">
                            <x-icon name="chart-pie" /> Overview
                        </a>
                        <a class="dash-nav__link is-active" href="{{ route('dashboard.profile.edit') }}">
                            <x-icon name="users" /> Investor profile
                        </a>
                        <a class="dash-nav__link" href="{{ route('contact') }}">
                            <x-icon name="message-square" /> New enquiry
                        </a>
                        <a class="dash-nav__link" href="{{ route('news.index') }}">
                            <x-icon name="book-open" /> News &amp; briefings
                        </a>
                    </nav>
                    <form method="POST" action="{{ route('logout') }}" class="dash-nav__logout">
                        @csrf
                        <button type="submit" class="dash-nav__link dash-nav__link--button">
                            <x-icon name="log-in" /> Sign out
                        </button>
                    </form>
                </aside>

                {{-- Form --}}
                <div class="dash-main">
                    <div class="dash-head">
                        <div>
                            <span class="eyebrow">Profile</span>
                            <h1>Investor Profile</h1>
                            <p class="lead mb-0">Kept private and used only by the advisory desk to respond to your enquiries.</p>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-mia-success" role="status">
                            <x-icon name="circle-check-big" class="icon" />
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif

                    <div class="dash-block">
                        <div class="dash-block__head">
                            <h2>Account details</h2>
                            <span class="status-badge {{ $user->hasCompletedProfile() ? 'status-badge--closed' : 'status-badge--new' }}">
                                {{ $user->hasCompletedProfile() ? 'Profile complete' : 'Profile incomplete' }}
                            </span>
                        </div>

                        <form method="POST" action="{{ route('dashboard.profile.update') }}" class="dash-form" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="auth-row">
                                <div class="auth-field">
                                    <label for="p-name" class="form-label-mia">Full name <span class="req" aria-hidden="true">*</span></label>
                                    <input id="p-name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                                        class="form-control-mia @error('name') is-invalid @enderror">
                                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                                </div>
                                <div class="auth-field">
                                    <label for="p-email" class="form-label-mia">Email address <span class="req" aria-hidden="true">*</span></label>
                                    <input id="p-email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                                        class="form-control-mia @error('email') is-invalid @enderror">
                                    @error('email')<div class="form-error">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="auth-row">
                                <div class="auth-field">
                                    <label for="p-company" class="form-label-mia">Company <span class="opt">optional</span></label>
                                    <input id="p-company" name="company" type="text" value="{{ old('company', $user->company) }}"
                                        class="form-control-mia @error('company') is-invalid @enderror">
                                    @error('company')<div class="form-error">{{ $message }}</div>@enderror
                                </div>
                                <div class="auth-field">
                                    <label for="p-country" class="form-label-mia">Country <span class="opt">optional</span></label>
                                    <input id="p-country" name="country" type="text" value="{{ old('country', $user->country) }}"
                                        class="form-control-mia @error('country') is-invalid @enderror">
                                    @error('country')<div class="form-error">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="auth-row">
                                <div class="auth-field">
                                    <label for="p-phone" class="form-label-mia">Telephone <span class="opt">optional</span></label>
                                    <input id="p-phone" name="phone" type="tel" value="{{ old('phone', $user->phone) }}"
                                        class="form-control-mia @error('phone') is-invalid @enderror">
                                    @error('phone')<div class="form-error">{{ $message }}</div>@enderror
                                </div>
                                <div class="auth-field">
                                    <label for="p-type" class="form-label-mia">Investor type <span class="opt">optional</span></label>
                                    <select id="p-type" name="investor_type"
                                        class="form-control-mia @error('investor_type') is-invalid @enderror">
                                        <option value="">— Select —</option>
                                        <option value="individual" @selected(old('investor_type', $user->investor_type) === 'individual')>Individual investor</option>
                                        <option value="company" @selected(old('investor_type', $user->investor_type) === 'company')>Company</option>
                                        <option value="fund" @selected(old('investor_type', $user->investor_type) === 'fund')>Fund / institutional</option>
                                        <option value="advisor" @selected(old('investor_type', $user->investor_type) === 'advisor')>Advisor / intermediary</option>
                                    </select>
                                    @error('investor_type')<div class="form-error">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="dash-form__section">
                                <h3>Change password</h3>
                                <p class="field-hint">Leave blank to keep your current password.</p>
                                <div class="auth-row">
                                    <div class="auth-field">
                                        <label for="p-current" class="form-label-mia">Current password</label>
                                        <input id="p-current" name="current_password" type="password" autocomplete="current-password"
                                            class="form-control-mia @error('current_password') is-invalid @enderror">
                                        @error('current_password')<div class="form-error">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="auth-field">
                                        <label for="p-password" class="form-label-mia">New password</label>
                                        <input id="p-password" name="password" type="password" autocomplete="new-password"
                                            class="form-control-mia @error('password') is-invalid @enderror">
                                        @error('password')<div class="form-error">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="auth-row">
                                    <div class="auth-field">
                                        <label for="p-password-confirm" class="form-label-mia">Confirm new password</label>
                                        <input id="p-password-confirm" name="password_confirmation" type="password"
                                            autocomplete="new-password" class="form-control-mia">
                                    </div>
                                </div>
                            </div>

                            <div class="dash-form__actions">
                                <button type="submit" class="btn btn-mia btn-gold-mia">
                                    Save changes <x-icon name="circle-check-big" class="icon" />
                                </button>
                                <a class="btn btn-mia btn-outline-mia" href="{{ route('dashboard') }}">Cancel</a>
                            </div>
                        </form>
                    </div>

                    <p class="dash-note">
                        The agency is privately operated. Account details are stored to respond to your
                        enquiries and are not shared with third parties for marketing.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
