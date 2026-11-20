{{-- Shared create/edit form. Expects $industry (existing or new model). --}}
<div class="admin-detail">
    <div class="admin-detail__main">
        <section class="dash-block">
            <div class="dash-block__head">
                <h2>Sector details</h2>
            </div>

            <div class="dash-form">
                <div class="auth-field">
                    <label for="name" class="form-label-mia">Name <span class="req">*</span></label>
                    <input type="text" id="name" name="name" maxlength="120" required
                        class="form-control-mia @error('name') is-invalid @enderror"
                        value="{{ old('name', $industry->name) }}">
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="auth-field">
                    <label for="slug" class="form-label-mia">URL slug <span class="opt">Optional</span></label>
                    <input type="text" id="slug" name="slug" maxlength="140"
                        class="form-control-mia @error('slug') is-invalid @enderror"
                        value="{{ old('slug', $industry->slug) }}" placeholder="generated-from-the-name">
                    <p class="field-hint">Leave blank to generate one from the name.</p>
                    @error('slug')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="auth-field">
                    <label for="icon" class="form-label-mia">Lucide icon <span class="opt">Optional</span></label>
                    <input type="text" id="icon" name="icon" maxlength="50"
                        class="form-control-mia @error('icon') is-invalid @enderror"
                        value="{{ old('icon', $industry->icon) }}" placeholder="e.g. landmark">
                    <p class="field-hint">Name of a lucide SVG icon from the public asset library.</p>
                    @error('icon')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="auth-field">
                    <label for="summary" class="form-label-mia">Public summary <span class="opt">Optional</span></label>
                    <textarea id="summary" name="summary" rows="3" maxlength="300"
                        class="form-control-mia @error('summary') is-invalid @enderror"
                        placeholder="One or two sentences explaining what this sector covers.">{{ old('summary', $industry->summary) }}</textarea>
                    <p class="field-hint">Keep it factual — no approval promises.</p>
                    @error('summary')<div class="form-error">{{ $message }}</div>@enderror
                </div>
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
                            @checked((bool) old('is_active', $industry->is_active ?? true))>
                        <span>
                            <strong>Published</strong>
                            <span class="admin-sub">Unchecked sectors stay in the console only.</span>
                        </span>
                    </label>
                </div>

                <div class="auth-field">
                    <label for="sort_order" class="form-label-mia">Sort order</label>
                    <input type="number" id="sort_order" name="sort_order" min="0" max="9999"
                        class="form-control-mia @error('sort_order') is-invalid @enderror"
                        value="{{ old('sort_order', $industry->sort_order ?? 0) }}">
                    <p class="field-hint">Lower numbers appear first.</p>
                    @error('sort_order')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="dash-form__actions">
                    <button type="submit" class="btn btn-mia btn-gold-mia">
                        {{ $industry->exists ? 'Save changes' : 'Add sector' }}
                    </button>
                    <a class="btn btn-mia btn-outline-mia" href="{{ route('admin.sectors.index') }}">Cancel</a>
                </div>
            </div>
        </section>
    </aside>
</div>