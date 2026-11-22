<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Overview') — Agency Console</title>
    <meta name="description" content="@yield('description', 'Private staff console for Meridian Investment Agency: enquiry queue, assignment and internal notes.')">
    <meta name="robots" content="noindex, nofollow">

    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/logos/favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body class="admin-body">
    <a class="visually-hidden-focusable" href="#admin-main">Skip to main content</a>

    @php
        $queueCount = \App\Models\Enquiry::query()->where('status', 'new')->count();
    @endphp

    <div class="admin-shell">
        <aside class="admin-side">
            <div class="admin-side__brand">
                <x-brand :light="true" :href="route('admin.dashboard')" tag="Agency Console"
                    :label="config('app.name').' — agency console home'" />
            </div>

            <nav class="admin-nav" aria-label="Back office">
                <span class="admin-nav__label">Pipeline</span>
                <a class="admin-nav__link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}"
                    href="{{ route('admin.dashboard') }}" @if (request()->routeIs('admin.dashboard')) aria-current="page" @endif>
                    <x-icon name="chart-pie" /> Overview
                </a>
                <a class="admin-nav__link {{ request()->routeIs('admin.enquiries.*') ? 'is-active' : '' }}"
                    href="{{ route('admin.enquiries.index') }}" @if (request()->routeIs('admin.enquiries.*')) aria-current="page" @endif>
                    <x-icon name="message-square" /> Enquiries
                    @if ($queueCount > 0)
                        <span class="admin-nav__count">{{ $queueCount }}</span>
                    @endif
                </a>

                <span class="admin-nav__label">Content</span>
                <a class="admin-nav__link {{ request()->routeIs('admin.permits.*') ? 'is-active' : '' }}"
                    href="{{ route('admin.permits.index') }}" @if (request()->routeIs('admin.permits.*')) aria-current="page" @endif>
                    <x-icon name="banknote" /> Permits &amp; pricing
                </a>
                <span class="admin-nav__pending">
                    <x-icon name="file-text" /> <span>Sectors, opportunities and news</span>
                    @if (auth()->user()->isAdmin())
                        <a class="admin-nav__link admin-nav__pending admin-nav__soon"
                           href="{{ route('admin.sectors.index') }}"
                           aria-label="Sectors management">
                            Sectors
                        </a>
                        <a class="admin-nav__link admin-nav__pending admin-nav__soon"
                           href="{{ route('admin.opportunities.index') }}"
                           aria-label="Investment opportunities management">
                            Opportunities
                        </a>
                        <a class="admin-nav__link admin-nav__pending admin-nav__soon"
                           href="{{ route('admin.news.index') }}"
                           aria-label="News management">
                            News
                        </a>
                    @endif
                </span>
                <a class="admin-nav__link admin-nav__pending"
                   href="{{ route('admin.profile.edit') }}"
                   aria-label="Edit your profile">
                    <x-icon name="user" /> Profile
                </a>
            </nav>

            <div class="admin-side__foot">
                <div class="admin-user">
                    <span class="admin-user__avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                    <span>
                        <span class="admin-user__name">{{ auth()->user()->name }}</span>
                        <span class="admin-user__email">{{ auth()->user()->email }}</span>
                    </span>
                </div>
                <a class="admin-side__link" href="{{ route('home') }}">
                    <x-icon name="external-link" /> View public site
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="admin-side__link admin-side__link--button">
                        <x-icon name="log-in" /> Sign out
                    </button>
                </form>
            </div>
        </aside>

        <div class="admin-main">
            <header class="admin-top">
                <nav aria-label="Breadcrumb" class="admin-crumbs">
                    <a href="{{ route('admin.dashboard') }}">Console</a>
                    <x-icon name="chevron-right" />
                    <span aria-current="page">@yield('crumb', 'Overview')</span>
                </nav>
                <span class="admin-top__site">Private area — staff only</span>
            </header>

            <main id="admin-main" class="admin-content">
                @if (session('success'))
                    <div class="alert alert-mia-success" role="status">
                        <x-icon name="circle-check-big" class="icon" />
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="{{ asset('assets/vendor/bootstrap.bundle.min.js') }}" defer></script>
</body>
</html>
