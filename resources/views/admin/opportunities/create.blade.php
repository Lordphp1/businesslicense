@extends('layouts.admin')

@section('title', 'Add opportunity')
@section('crumb', 'Opportunities / Add')

@section('content')
    <div class="admin-page-head">
        <div>
            <a class="textlink admin-back" href="{{ route('admin.opportunities.index') }}">
                <x-icon name="arrow-right" class="icon icon--back" /> Back to opportunities
            </a>
            <h1 class="admin-title">Add an investment opportunity</h1>
            <p class="admin-sub-line">Showcase an investment opportunity on the public site.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.opportunities.store') }}">
        @csrf

        @include('admin.opportunities._form')
    </form>
@endsection