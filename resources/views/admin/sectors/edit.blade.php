@extends('layouts.admin')

@section('title', 'Edit '.$industry->name)
@section('crumb', 'Sectors / '.Str::limit($industry->name, 40))

@section('content')
    <div class="admin-page-head">
        <div>
            <a class="textlink admin-back" href="{{ route('admin.sectors.index') }}">
                <x-icon name="arrow-right" class="icon icon--back" /> Back to sectors
            </a>
            <h1 class="admin-title">{{ $industry->name }}</h1>
            <p class="admin-sub-line">
                {{ $industry->slug }}
                · <span class="status-badge status-badge--{{ $industry->is_active ? 'active' : 'inactive' }}">{{ $industry->is_active ? 'Published' : 'Hidden' }}</span>
            </p>
        </div>
        <a class="textlink" href="{{ route('sectors.index') }}" target="_blank" rel="noopener">
            View public page <x-icon name="external-link" />
        </a>
    </div>

    <form method="POST" action="{{ route('admin.sectors.update', $industry) }}">
        @csrf
        @method('PUT')
        @include('admin.sectors._form')
    </form>
@endsection