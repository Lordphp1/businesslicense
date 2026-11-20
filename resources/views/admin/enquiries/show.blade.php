@extends('layouts.admin')

@section('title', Str::limit($enquiry->subject ?: 'Enquiry from '.$enquiry->name, 52))
@section('crumb', 'Enquiries / '.Str::limit($enquiry->subject ?: $enquiry->name, 40))

@section('content')
    <div class="admin-page-head">
        <div>
            <a class="textlink admin-back" href="{{ route('admin.enquiries.index') }}">
                <x-icon name="arrow-right" class="icon icon--back" /> Back to the queue
            </a>
            <h1 class="admin-title">{{ $enquiry->subject ?: 'Enquiry from '.$enquiry->name }}</h1>
            <p class="admin-sub-line">
                Received {{ $enquiry->created_at->format('j F Y') }} at {{ $enquiry->created_at->format('H:i') }}
                · Ref #{{ str_pad((string) $enquiry->id, 4, '0', STR_PAD_LEFT) }}
            </p>
        </div>
        <span class="status-badge status-badge--{{ $enquiry->status }}">{{ ucfirst($enquiry->status) }}</span>
    </div>

    <div class="admin-detail">
        <div class="admin-detail__main">
            <section class="dash-block">
                <div class="dash-block__head">
                    <h2>Message</h2>
                    @if ($enquiry->industry)
                        <span class="admin-tag admin-tag--sector">{{ $enquiry->industry->name }}</span>
                    @endif
                </div>
                <p class="admin-message">{{ $enquiry->message }}</p>
            </section>

            <section class="dash-block">
                <div class="dash-block__head">
                    <h2>Internal notes</h2>
                    <span class="dash-block__meta">{{ $enquiry->notes->count() }} {{ Str::plural('note', $enquiry->notes->count()) }}</span>
                </div>

                @if ($enquiry->notes->isEmpty())
                    <p class="admin-empty-note">
                        No notes yet. Notes are internal — the investor never sees them.
                    </p>
                @else
                    <ol class="admin-thread">
                        @foreach ($enquiry->notes as $note)
                            <li class="admin-thread__item">
                                <div class="admin-thread__meta">
                                    <strong>{{ $note->author?->name ?? 'Former staff member' }}</strong>
                                    <span>{{ $note->created_at->format('j M Y, H:i') }}</span>
                                </div>
                                <p>{{ $note->body }}</p>
                            </li>
                        @endforeach
                    </ol>
                @endif

                <form method="POST" action="{{ route('admin.enquiries.notes.store', $enquiry) }}" class="admin-note-form">
                    @csrf
                    <label for="note-body" class="form-label-mia">Add a note</label>
                    <textarea id="note-body" name="body" rows="3" required
                        class="form-control-mia @error('body') is-invalid @enderror"
                        placeholder="What was agreed, what the investor needs to send, next steps…">{{ old('body') }}</textarea>
                    @error('body')<div class="form-error">{{ $message }}</div>@enderror
                    <div class="admin-note-form__actions">
                        <button type="submit" class="btn btn-mia btn-outline-mia">
                            Save note <x-icon name="send" class="icon" />
                        </button>
                    </div>
                </form>
            </section>
        </div>

        <aside class="admin-detail__aside">
            <section class="dash-block">
                <div class="dash-block__head">
                    <h2>Handling</h2>
                </div>
                <form method="POST" action="{{ route('admin.enquiries.update', $enquiry) }}" class="dash-form">
                    @csrf
                    @method('PUT')

                    <div class="auth-field">
                        <label for="status" class="form-label-mia">Status</label>
                        <select id="status" name="status" class="form-control-mia @error('status') is-invalid @enderror">
                            @foreach (\App\Models\Enquiry::STATUSES as $status)
                                <option value="{{ $status }}" @selected(old('status', $enquiry->status) === $status)>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="auth-field">
                        <label for="assigned_to" class="form-label-mia">Assigned to</label>
                        <select id="assigned_to" name="assigned_to" class="form-control-mia @error('assigned_to') is-invalid @enderror">
                            <option value="">Unassigned</option>
                            @foreach ($staff as $member)
                                <option value="{{ $member->id }}" @selected((string) old('assigned_to', $enquiry->assigned_to) === (string) $member->id)>
                                    {{ $member->name }}{{ $member->id === auth()->id() ? ' (you)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        <p class="field-hint">Setting the status to “Assigned” requires an owner.</p>
                        @error('assigned_to')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="dash-form__actions">
                        <button type="submit" class="btn btn-mia btn-gold-mia">Save</button>
                    </div>
                </form>
            </section>

            <section class="dash-block">
                <div class="dash-block__head">
                    <h2>Investor</h2>
                </div>
                <dl class="admin-facts">
                    <dt>Name</dt>
                    <dd>{{ $enquiry->name }}</dd>
                    <dt>Email</dt>
                    <dd><a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></dd>
                    @if ($enquiry->phone)
                        <dt>Telephone</dt>
                        <dd><a href="tel:{{ $enquiry->phone }}">{{ $enquiry->phone }}</a></dd>
                    @endif
                    @if ($enquiry->country)
                        <dt>Country</dt>
                        <dd>{{ $enquiry->country }}</dd>
                    @endif
                    <dt>Account</dt>
                    <dd>
                        @if ($enquiry->user)
                            {{ $enquiry->user->name }}
                            <span class="admin-sub">{{ $enquiry->user->company ?: 'Investor account' }}</span>
                        @else
                            Visitor — no account
                        @endif
                    </dd>
                    <dt>Source</dt>
                    <dd>{{ $enquiry->source === 'contact-page' ? 'Contact form' : $enquiry->source }}</dd>
                    @if ($enquiry->handled_at)
                        <dt>Closed</dt>
                        <dd>{{ $enquiry->handled_at->format('j M Y') }}</dd>
                    @endif
                </dl>

                <a class="btn btn-mia btn-outline-mia w-100 mt-3"
                    href="mailto:{{ $enquiry->email }}?subject={{ rawurlencode('Your enquiry with Meridian Investment Agency') }}">
                    <x-icon name="mail" class="icon" /> Reply by email
                </a>
            </section>
        </aside>
    </div>
@endsection
