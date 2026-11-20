<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @hasSection('title')
        <title>@yield('title') — {{ config('app.name') }}</title>
        <meta property="og:title" content="@yield('title')">
    @else
        <title>{{ config('app.name') }} — Investment &amp; Business Development</title>
        <meta property="og:title" content="{{ config('app.name') }}">
    @endif

    @hasSection('description')
        <meta name="description" content="@yield('description')">
        <meta property="og:description" content="@yield('description')">
    @else
        <meta name="description" content="{{ $description ?? 'Discover investment opportunities, establish your business and access professional investor support.' }}">
        <meta property="og:description" content="{{ $description ?? 'Discover investment opportunities, establish your business and access professional investor support.' }}">
    @endif

    @if (isset($canonical))
        <link rel="canonical" href="{{ $canonical }}">
    @endif

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:image" content="{{ $ogImage ?? asset('assets/images/hero/hero-tower-architecture.jpg') }}">
    <meta name="twitter:card" content="summary_large_image">

    {{-- Robots: public site is indexable; authenticated areas set noindex themselves --}}
    <meta name="robots" content="{{ $robots ?? 'index, follow' }}">

    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/logos/favicon.svg') }}">

    {{-- Static assets, no build step --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

    {{-- Structured data: organisation --}}
    @isset($structuredData)
        <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @endisset
</head>
<body>
    <a class="visually-hidden-focusable" href="#main">Skip to main content</a>

    @include('partials.nav')

    <main id="main">
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="{{ asset('assets/vendor/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/app.js') }}" defer></script>
</body>
</html>
