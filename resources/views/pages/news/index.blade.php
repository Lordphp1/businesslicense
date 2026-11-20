@extends('layouts.public')

@section('description', 'News, briefings, publications and press releases from the Meridian Investment Agency newsroom.')

@section('title', 'News & Publications')

@section('content')
    <x-page-head
        title="News & Publications"
        lead="Briefings, publications and press releases from the agency. Content is published as it is confirmed." />

    <section class="section section--bg">
        <div class="container container-mia">
            @if ($featured)
                @php($fi = $featured->image())
                <a class="news-hero" href="{{ route('news.show', $featured) }}">
                    @if ($fi)
                        <div class="news-hero__media">
                            <div class="media-frame media-frame--16x9">
                                <img src="{{ asset($fi['path']) }}" alt="{{ $fi['alt'] }}" loading="lazy">
                            </div>
                        </div>
                    @endif
                    <div class="news-hero__body">
                        <span class="badge-mia">Featured</span>
                        <span class="news-feature__cat">{{ ucfirst($featured->category) }}</span>
                        <h2>{{ $featured->title }}</h2>
                        <p>{{ $featured->excerpt }}</p>
                        <span class="news-date">
                            <x-icon name="calendar" /> {{ $featured->published_at->format('j F Y') }}
                        </span>
                    </div>
                </a>
            @endif

            <div class="row g-5 mt-lg-5">
                @forelse ($posts as $post)
                    @php($ni = $post->image())
                    <div class="col-lg-4 col-md-6">
                        <a class="news-feature" href="{{ route('news.show', $post) }}">
                            @if ($ni)
                                <div class="media-frame media-frame--3x2">
                                    <img src="{{ asset($ni['path']) }}" alt="{{ $ni['alt'] }}" loading="lazy">
                                </div>
                            @endif
                            <span class="news-feature__cat">{{ ucfirst($post->category) }}</span>
                            <h3>{{ $post->title }}</h3>
                            <p>{{ $post->excerpt }}</p>
                            <span class="news-date mt-2">
                                <x-icon name="calendar" /> {{ $post->published_at->format('j F Y') }}
                            </span>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state">
                            <h3>No news published yet</h3>
                            <p>Announcements and briefings will appear here as they are released.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="cta-band">
        <div class="container container-mia">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-4">
                <div>
                    <h2>Stay informed</h2>
                    <p>For briefings on registration policy and sector developments, contact the agency directly.</p>
                </div>
                <div class="cta-band__actions">
                    <a class="btn btn-mia btn-gold-mia" href="{{ route('contact') }}">
                        Contact the agency <x-icon name="arrow-right" class="icon icon--arrow" />
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
