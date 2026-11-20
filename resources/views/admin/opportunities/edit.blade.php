@extends('layouts.admin')

@section('title', 'Edit '.$opportunity->title)
@section('crumb', 'Opportunities / '.Str::limit($opportunity->title, 40))

@section('content')
    <div class="admin-page-head">
        <div>
            <a class="textlink admin-back" href="{{ route('admin.opportunities.index') }}">
                <x-icon name="arrow-right" class="icon icon--back" /> Back to opportunities
            </a>
            <h1 class="admin-title">{{ $opportunity->title }}</h1>
            <p class="admin-sub-line">
                {{ $opportunity->industry?->name ?? 'No sector' }}
                · <span class="status-badge status-badge--{{ $opp->status === 'published' ? 'active' : 'inactive' }}">
                    {{ ucfirst($opp->status) }}
                </span>
            </p>
        </div>
        <a class="textlink" href="{{ route('opportunities.index') }}" target="_blank" rel="noopener">
            View public page <x-icon name="external-link" />
        </a>
    </div>

    <form method="POST" action="{{ route('admin.opportunities.update', $opp) }}">
        @csrf
        @method('PUT')
        @include('admin.opportunities._form')
    </form>
@endsection