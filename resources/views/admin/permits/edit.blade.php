@extends('layouts.admin')

@section('title', 'Edit '.$permit->name)
@section('crumb', 'Permits / '.Str::limit($permit->name, 40))

@section('content')
    <div class="admin-page-head">
        <div>
            <a class="textlink admin-back" href="{{ route('admin.permits.index') }}">
                <x-icon name="arrow-right" class="icon icon--back" /> Back to permits
            </a>
            <h1 class="admin-title">{{ $permit->name }}</h1>
            <p class="admin-sub-line">
                {{ $permit->slug }}
                · <span class="status-badge status-badge--{{ $permit->is_active ? 'active' : 'inactive' }}">{{ $permit->is_active ? 'Published' : 'Hidden' }}</span>
            </p>
        </div>
        <a class="textlink" href="{{ route('licensing') }}#permits" target="_blank" rel="noopener">
            View public page <x-icon name="external-link" />
        </a>
    </div>

    <form method="POST" action="{{ route('admin.permits.update', $permit) }}">
        @csrf
        @method('PUT')
        @include('admin.permits._form')
    </form>
@endsection
