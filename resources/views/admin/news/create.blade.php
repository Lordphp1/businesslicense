@extends('layouts.admin')

@section('title', 'Add news post')
@section('crumb', 'News / Add')

@section('content')
    <div class="admin-page-head">
        <div>
            <a class="textlink admin-back" href="{{ route('admin.news.index') }}">
                <x-icon name="arrow-right" class="icon icon--back" /> Back to news
            </a>
            <h1 class="admin-title">Add a news post</h1>
            <p class="admin-sub-line">Share an agency update or publication.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.news.store') }}">
        @csrf

        @include('admin.news._form')
    </form>
@endsection