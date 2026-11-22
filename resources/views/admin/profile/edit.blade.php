@extends('layouts.admin')

@section('title', 'Profile — Agency Console')
@section('description', 'Edit your admin profile information')

@section('content')
<div class="admin-page-head">
    <div>
        <span class="eyebrow">Profile</span>
        <h1>My Profile</h1>
    </div>
</div>

<form method="POST" action="{{ route('profile.update') }}" aria-label="Edit admin profile">
    @csrf @method('PUT')

    <div class="form-group">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required autocomplete="name">
    </div>

    <div class="form-group">
        <label for="phone" class="form-label">Phone Number</label>
        <input type="tel" name="phone" id="phone" class="form-control" value="{{ old('phone', auth()->user()->phone) }}" autocomplete="tel">
    </div>

    <div class="form-group">
        <label for="country" class="form-label">Country</label>
        <input type="text" name="country" id="country" class="form-control" value="{{ old('country', auth()->user()->country) }}" autocomplete="country-name">
    </div>

    <div class="form-group">
        <label for="company" class="form-label">Company</label>
        <input type="text" name="company" id="company" class="form-control" value="{{ old('company', auth()->user()->company) }}" autocomplete="organization-name">
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-mia btn-gold-mia">
            Save Changes
        </button>
        <a class="btn btn-mia btn-outline-mia" href="{{ route('admin.dashboard') }}">
            Cancel
        </a>
    </div>
</form>
@endsection