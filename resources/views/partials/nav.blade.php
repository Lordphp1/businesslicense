{{-- Top utility bar --}}
<div class="topbar d-none d-md-block">
    <div class="container container-mia d-flex justify-content-between align-items-center">
        <ul class="list-unstyled d-flex gap-4 mb-0">
            <li class="d-flex align-items-center gap-2">
                <x-icon name="phone" /> <span>Office hours: Mon–Fri, 08:30–17:30</span>
            </li>
            <li class="d-flex align-items-center gap-2">
                <x-icon name="map-pin" /> <span>Investor enquiry desk available by appointment</span>
            </li>
        </ul>
        <ul class="list-unstyled d-flex gap-3 mb-0">
            <li><a href="{{ route('news.index') }}">Newsroom</a></li>
            <li><a href="{{ route('contact') }}">Contact</a></li>
        </ul>
    </div>
</div>

{{-- Primary navigation --}}
<header class="site-nav">
    <div class="container container-mia">
        <div class="site-nav__inner">
            <x-brand />

            <nav class="site-nav__links" aria-label="Primary">
                <a class="site-nav__link" href="{{ route('home') }}">Home</a>

                <div class="dropdown">
                    <button class="site-nav__link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        About <x-icon name="chevron-down" />
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('about') }}">About the Agency</a></li>
                        <li><a class="dropdown-item" href="{{ route('about') }}#mission">Mission &amp; Mandate</a></li>
                        <li><a class="dropdown-item" href="{{ route('news.index') }}">News &amp; Publications</a></li>
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="site-nav__link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Invest <x-icon name="chevron-down" />
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('opportunities.index') }}">Investment Opportunities</a></li>
                        <li><a class="dropdown-item" href="{{ route('sectors.index') }}">Priority Sectors</a></li>
                        <li><a class="dropdown-item" href="{{ route('services') }}">Investor Services</a></li>
                    </ul>
                </div>

                <a class="site-nav__link" href="{{ route('sectors.index') }}">Sectors</a>

                <div class="dropdown">
                    <button class="site-nav__link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Business Setup <x-icon name="chevron-down" />
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('start-business') }}">Start a Business Guide</a></li>
                        <li><a class="dropdown-item" href="{{ route('registration') }}">Business Registration</a></li>
                        <li><a class="dropdown-item" href="{{ route('licensing') }}">Business Licensing</a></li>
                    </ul>
                </div>

                <a class="site-nav__link" href="{{ route('news.index') }}">News</a>
            </nav>

            <div class="site-nav__actions">
                <a class="iconbtn" href="{{ route('opportunities.index') }}" aria-label="Search investment opportunities">
                    <x-icon name="search" />
                </a>
                @auth
                    @if (auth()->user()->isAdmin())
                        <a class="nav-login" href="{{ route('admin.dashboard') }}">Admin Console</a>
                    @else
                        <a class="nav-login" href="{{ route('dashboard') }}">Dashboard</a>
                    @endif
                @else
                    <a class="nav-login" href="{{ route('login') }}">Investor Login</a>
                @endauth
                <a class="btn btn-mia btn-primary-mia d-none d-sm-inline-flex" href="{{ route('start-business') }}">
                    Start Investing <x-icon name="arrow-right" class="icon icon--arrow" />
                </a>
                <button class="iconbtn nav-burger" type="button" data-bs-toggle="offcanvas" data-bs-target="#navDrawer" aria-controls="navDrawer" aria-label="Open navigation menu">
                    <x-icon name="menu" />
                </button>
            </div>
        </div>
    </div>
</header>

{{-- Mobile drawer --}}
<div class="offcanvas offcanvas-end nav-drawer" tabindex="-1" id="navDrawer" aria-labelledby="navDrawerLabel">
    <div class="offcanvas-header pt-4">
        <x-brand light />
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="nav-drawer__links">
            <li><a class="nav-drawer__link" href="{{ route('home') }}">Home <x-icon name="arrow-right" /></a></li>
            <li><a class="nav-drawer__link" href="{{ route('about') }}">About the Agency <x-icon name="arrow-right" /></a></li>
            <li><a class="nav-drawer__link" href="{{ route('opportunities.index') }}">Investment Opportunities <x-icon name="arrow-right" /></a></li>
            <li><a class="nav-drawer__link" href="{{ route('sectors.index') }}">Priority Sectors <x-icon name="arrow-right" /></a></li>
            <li><a class="nav-drawer__link" href="{{ route('services') }}">Investor Services <x-icon name="arrow-right" /></a></li>
            <li><a class="nav-drawer__link" href="{{ route('start-business') }}">Start a Business <x-icon name="arrow-right" /></a></li>
            <li><a class="nav-drawer__link" href="{{ route('registration') }}">Business Registration <x-icon name="arrow-right" /></a></li>
            <li><a class="nav-drawer__link" href="{{ route('licensing') }}">Business Licensing <x-icon name="arrow-right" /></a></li>
            <li><a class="nav-drawer__link" href="{{ route('news.index') }}">News &amp; Publications <x-icon name="arrow-right" /></a></li>
            <li><a class="nav-drawer__link" href="{{ route('contact') }}">Contact <x-icon name="arrow-right" /></a></li>
        </ul>
        <div class="nav-drawer__cta">
            @auth
                @if (auth()->user()->isAdmin())
                    <a class="btn btn-mia btn-gold-mia" href="{{ route('admin.dashboard') }}">Admin Console</a>
                @else
                    <a class="btn btn-mia btn-gold-mia" href="{{ route('dashboard') }}">Investor Dashboard</a>
                @endif
            @else
                <a class="btn btn-mia btn-gold-mia" href="{{ route('login') }}">Investor Login</a>
                <a class="btn btn-mia btn-outline-light-mia" href="{{ route('register') }}">Create an account</a>
            @endauth
            <a class="btn btn-mia btn-outline-light-mia" href="{{ route('start-business') }}">Start Your Business</a>
        </div>
    </div>
</div>
