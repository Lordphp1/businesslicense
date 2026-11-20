@extends('layouts.public')

@section('title', $post->title)
@section('description', $post->excerpt)

@section('content')
    <article>
        <header class="page-head">
            <div class="container container-mia">
                <nav aria-label="Breadcrumb" class="page-head__crumbs">
                    <a href="{{ route('home') }}">Home</a>
                    <x-icon name="chevron-right" />
                    <a href="{{ route('news.index') }}">News</a>
                    <x-icon name="chevron-right" />
                    <span aria-current="page">Article</span>
                </nav>
                <h1 class="article-title">{{ $post->title }}</h1>
                <p class="lead mb-0">
                    <span class="news-date">
                        <x-icon name="calendar" /> Published {{ $post->published_at->format('j F Y') }}
                    </span>
                    @if ($post->image())
                        &nbsp;·&nbsp;{{ ucfirst($post->category) }}
                    @endif
                </p>
            </div>
        </header>

        <section class="section section--bg">
            <div class="container container-mia">
                @php($pi = $post->image())
                @if ($pi)
                    <div class="media-frame media-frame--16x9 article-media">
                        <img src="{{ asset($pi['path']) }}" alt="{{ $pi['alt'] }}">
                    </div>
                @endif

                <div class="article-body">
                    <p class="lead article-lead">{{ $post->excerpt }}</p>
                    {!! nl2br(e($post->body)) !!}
                </div>

                @if ($related->isNotEmpty())
                    <aside class="article-related">
                        <span class="eyebrow">More from the newsroom</span>
                        <div class="article-related__list">
                            @foreach ($related as $item)
                                <a class="article-related__item" href="{{ route('news.show', $item) }}">
                                    <span>{{ $item->title }}</span>
                                    <span class="news-date">
                                        <x-icon name="calendar" /> {{ $item->published_at->format('j F Y') }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </aside>
                @endif

                <div class="mt-4">
                    <a class="textlink" href="{{ route('news.index') }}">
                        Back to all news <x-icon name="arrow-right" />
                    </a>
                </div>
            </div>
        </section>
    </article>

    {{-- CTA --}}
    <section class="cta-band">
        <div class="container container-mia">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-4">
                <div>
                    <h2>Questions about this briefing?</h2>
                    <p>The advisory desk can clarify what this means for your establishment plans.</p>
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
