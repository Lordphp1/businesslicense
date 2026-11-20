@extends('layouts.admin')

@section('title', 'Edit '.$post->title)
@section('crumb', 'News / '.Str::limit($post->title, 40))

@section('content')
    <div class="admin-page-head">
        <div>
            <a class="textlink admin-back" href="{{ route('admin.news.index') }}">
                <x-icon name="arrow-right" class="icon icon--back" /> Back to news
            </a>
            <h1 class="admin-title">{{ $post->title }}</h1>
            <p class="admin-sub-line">
                {{ $post->category }}
                · <span class="status-badge status-badge--{{ $post->is_featured ? 'active' : 'inactive' }}">
                    {{ $post->is_featured ? 'Featured' : 'Not featured' }}
                </span>
                @if ($post->published_at)
                    · {{ $post->published_at->format('j M Y') }}
                @endif
            </p>
        </div>
        <a class="textlink" href="{{ route('news.index') }}" target="_blank" rel="noopener">
            View public page <x-icon name="external-link" />
        </a>
    </div>

    <form method="POST" action="{{ route('admin.news.update', $post) }}">
        @csrf
        @method('PUT')
        @include('admin.news._form')
    </form>
@endsection