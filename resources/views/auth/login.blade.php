@extends('layouts.public')

@section('title', 'Investor Login')
@section('description', 'Sign in to the Meridian Investment Agency investor portal to track your enquiries and manage your investor profile.')

@section('content')
    <section class="auth-shell">
        <div class="container container-mia">
            <div class="auth-grid">
                {{-- Brand panel --}}
                <div class="auth-panel">
                    <span class="eyebrow eyebrow--light">Investor portal</span>
                    <h1>Your establishment journey, in one place.</h1>
                    <p class="auth-panel__lead">
                        Sign in to follow your enquiries, keep your investor profile current and
                        see the agency's latest briefings.
                    </p>
                    <div class="auth-list">
                        <div class="auth-list__item">
                            <x-icon name="activity" class="icon" />
                            <div>
                                <span class="auth-list__t">Enquiry tracking</span>
                                <span class="auth-list__d">Every enquiry you submit is listed with its current status.</span>
                            </div>
                        </div>
                        <div class="auth-list__item">
                            <x-icon name="users" class="icon" />
                            <div>
                                <span class="auth-list__t">Investor profile</span>
                                <span class="auth-list__d">Keep your sector interest and contact details ready for the desk.</span>
                            </div>
                        </div>
                        <div class="auth-list__item">
                            <x-icon name="file-text" class="icon" />
                            <div>
                                <span class="auth-list__t">Document vault</span>
                                <span class="auth-list__d">Planned: upload documents once and reuse them across applications.</span>
                            </div>
                        </div>
                    </div>
                    <p class="auth-panel__foot">
                        Access requires identity verification when the full portal opens. The agency
                        never requests credentials or payments by unsolicited message.
                    </p>
                </div>

                {{-- Login form --}}
                <div class="auth-card">
                    <span class="eyebrow">Welcome back</span>
                    <h2>Sign in</h2>

                    @if (session('status'))
                        <div class="alert alert-mia-success" role="status">
                            <x-icon name="circle-check-big" class="icon" />
                            <div>{{ session('status') }}</div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.store') }}" class="auth-form" novalidate>
                        @csrf
                        <div class="auth-field">
                            <label for="login-email" class="form-label-mia">Email address</label>
                            <input id="login-email" name="email" type="email" autocomplete="email"
                                value="{{ old('email') }}" required autofocus
                                class="form-control-mia @error('email') is-invalid @enderror">
                            @error('email')<div class="form-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="auth-field">
                            <label for="login-password" class="form-label-mia">Password</label>
                            <input id="login-password" name="password" type="password"
                                autocomplete="current-password" required
                                class="form-control-mia @error('password') is-invalid @enderror">
                            @error('password')<div class="form-error">{{ $message }}</div>@enderror
                        </div>

                        <label class="auth-check">
                            <input type="checkbox" name="remember" value="1" @checked(old('remember'))>
                            <span>Keep me signed in on this device</span>
                        </label>

                        <button type="submit" class="btn btn-mia btn-gold-mia w-100">
                            Sign in <x-icon name="log-in" class="icon" />
                        </button>
                    </form>

                    <p class="auth-switch">
                        New to the portal? <a href="{{ route('register') }}">Create an investor account</a>
                    </p>

                    <div class="auth-card__note">
                        <x-icon name="lock" class="icon" />
                        <p>
                            Sign-in attempts are rate limited. If you are locked out, wait a few
                            minutes before trying again.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
