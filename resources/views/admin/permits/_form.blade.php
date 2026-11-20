{{-- Shared create/edit form. Expects $permit (existing or new model). --}}
<div class="admin-detail">
    <div class="admin-detail__main">
        <section class="dash-block">
            <div class="dash-block__head">
                <h2>Permit details</h2>
                <span class="dash-block__meta">Shown on the public licensing page</span>
            </div>

            <div class="dash-form">
                <div class="auth-field">
                    <label for="name" class="form-label-mia">Name <span class="req">*</span></label>
                    <input type="text" id="name" name="name" maxlength="120" required
                        class="form-control-mia @error('name') is-invalid @enderror"
                        value="{{ old('name', $permit->name) }}">
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="auth-field">
                    <label for="slug" class="form-label-mia">URL slug <span class="opt">Optional</span></label>
                    <input type="text" id="slug" name="slug" maxlength="140"
                        class="form-control-mia @error('slug') is-invalid @enderror"
                        value="{{ old('slug', $permit->slug) }}" placeholder="generated-from-the-name">
                    <p class="field-hint">Leave blank to generate one from the name.</p>
                    @error('slug')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="auth-field">
                    <label for="authority" class="form-label-mia">Issuing authority <span class="opt">Optional</span></label>
                    <input type="text" id="authority" name="authority" maxlength="150"
                        class="form-control-mia @error('authority') is-invalid @enderror"
                        value="{{ old('authority', $permit->authority) }}"
                        placeholder="e.g. State tax authority">
                    <p class="field-hint">Named for the investor's reference. The agency coordinates applications; it does not issue permits.</p>
                    @error('authority')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="auth-field">
                    <label for="summary" class="form-label-mia">Public summary <span class="opt">Optional</span></label>
                    <textarea id="summary" name="summary" rows="3" maxlength="300"
                        class="form-control-mia @error('summary') is-invalid @enderror"
                        placeholder="One or two sentences explaining what the permit covers.">{{ old('summary', $permit->summary) }}</textarea>
                    <p class="field-hint">Keep it factual — no approval promises or guaranteed timelines.</p>
                    @error('summary')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
        </section>

        <section class="dash-block">
            <div class="dash-block__head">
                <h2>Pricing</h2>
                <span class="dash-block__meta">Agency service fee</span>
            </div>

            <div class="dash-form">
                <div class="admin-field-grid">
                    <div class="auth-field">
                        <label for="fee" class="form-label-mia">Fee <span class="opt">Optional</span></label>
                        <input type="number" id="fee" name="fee" step="0.01" min="0" max="9999999999.99"
                            class="form-control-mia @error('fee') is-invalid @enderror"
                            value="{{ old('fee', $permit->fee) }}" placeholder="Leave blank to quote on assessment">
                        @error('fee')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="auth-field">
                        <label for="currency" class="form-label-mia">Currency <span class="req">*</span></label>
                        <input type="text" id="currency" name="currency" maxlength="3" required
                            class="form-control-mia @error('currency') is-invalid @enderror"
                            value="{{ strtoupper((string) old('currency', $permit->currency ?: 'USD')) }}"
                            placeholder="USD" inputmode="text" autocapitalize="characters">
                        <p class="field-hint">Three-letter ISO code.</p>
                        @error('currency')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="auth-field">
                    <label for="turnaround" class="form-label-mia">Indicative turnaround <span class="opt">Optional</span></label>
                    <input type="text" id="turnaround" name="turnaround" maxlength="80"
                        class="form-control-mia @error('turnaround') is-invalid @enderror"
                        value="{{ old('turnaround', $permit->turnaround) }}"
                        placeholder="e.g. 5–10 working days">
                    <p class="field-hint">Publish only an estimate confirmed against the issuing authority.</p>
                    @error('turnaround')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <p class="dash-note">
                    The fee shown publicly is the agency's own service fee. Statutory charges are set by
                    the issuing authority and invoiced separately. Leaving the fee blank publishes
                    “On assessment”.
                </p>
            </div>
        </section>
    </div>

    <aside class="admin-detail__aside">
        <section class="dash-block">
            <div class="dash-block__head">
                <h2>Visibility</h2>
            </div>

            <div class="dash-form">
                <div class="auth-field">
                    <input type="hidden" name="is_active" value="0">
                    <label class="admin-check" for="is_active">
                        <input type="checkbox" id="is_active" name="is_active" value="1"
                            @checked((bool) old('is_active', $permit->is_active ?? true))>
                        <span>
                            <strong>Published</strong>
                            <span class="admin-sub">Unchecked permits stay in the console only.</span>
                        </span>
                    </label>
                </div>

                <div class="auth-field">
                    <label for="sort_order" class="form-label-mia">Sort order</label>
                    <input type="number" id="sort_order" name="sort_order" min="0" max="9999"
                        class="form-control-mia @error('sort_order') is-invalid @enderror"
                        value="{{ old('sort_order', $permit->sort_order ?? 0) }}">
                    <p class="field-hint">Lower numbers appear first.</p>
                    @error('sort_order')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="dash-form__actions">
                    <button type="submit" class="btn btn-mia btn-gold-mia">
                        {{ $permit->exists ? 'Save changes' : 'Add permit' }}
                    </button>
                    <a class="btn btn-mia btn-outline-mia" href="{{ route('admin.permits.index') }}">Cancel</a>
                </div>
            </div>
        </section>
    </aside>
</div>
