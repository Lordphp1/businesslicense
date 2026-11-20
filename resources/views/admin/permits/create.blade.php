@extends('layouts.admin')

@section('title', 'Add permit')
@section('crumb', 'Permits / Add')

@section('content')
    <div class="admin-page-head">
        <div>
            <a class="textlink admin-back" href="{{ route('admin.permits.index') }}">
                <x-icon name="arrow-right" class="icon icon--back" /> Back to permits
            </a>
            <h1 class="admin-title">Add a permit</h1>
            <p class="admin-sub-line">Publish a permit and its agency fee on the public licensing page.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.permits.store') }}">
        @csrf
        @include('admin.permits._form')
    </form>
@endsection
