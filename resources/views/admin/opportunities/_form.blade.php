{{-- Shared create/edit form. Expects $opportunity (existing or new model). --}}
<div class="admin-detail">
    <div class="admin-detail__main">
        <section class="dash-block">
            <div class="dash-block__head">
                <h2>Investment opportunity details</h2>
            </div>

            <div class="dash-form">
                <div class="auth-field">
                    <label for="title" class="form-label-mia">Title <span class="req">*</span></label>
                    <input type="text" id="title" name="title" maxlength="200" required
                        class="form-control-mia @error('title') is-invalid @enderror"
                        value="{{ old('title', $opportunity->title) }}">
                    @error('title')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="auth-field">
                    <label for="summary" class="form-label-mia">Summary <span class="req">*</span></label>
                    <textarea id="summary" name="summary" rows="3" maxlength="500"
                        class="form-control-mia @error('summary') is-invalid @enderror"
                        placeholder="Brief description of the opportunity.">{{ old('summary', $opportunity->summary) }}</textarea>
                    @error('summary')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="auth-field">
                    <label for="industry_id" class="form-label-mia">Sector <span class="req">*</span></label>
                    <select id="industry_id" name="industry_id" class="form-control-mia @error('industry_id') is-invalid @enderror">
                        <option value="">Select a sector</option>
                        @foreach ($industries as $industry)
                            <option value="{{ $industry->id }}" @selected(old('industry_id', $opportunity->industry_id) === $industry->id)
                                {{ $industry->name }}{$industry->id === auth()->id() ? ' (you)' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('industry_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="auth-field">
                    <label for="location" class="form-label-mia">Location <span class="opt">Optional</span></label>
                    <input type="text" id="location" name="location" maxlength="200"
                        class="form-control-mia @error('location') is-invalid @enderror"
                        value="{{ old('location', $opportunity->location) }}"
                        placeholder="e.g. Dubai Industrial City">
                    @error('location')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="auth-field">
                    <label for="investment_min" class="form-label-mia">Minimum investment <span class="opt">Optional</span></label>
                    <input type="text" id="investment_min" name="investment_min" maxlength="100"
                        class="form-control-mia @error('investment_min') is-invalid @enderror"
                        value="{{ old('investment_min', $opportunity->investment_min) }}"
                        placeholder="e.g. $15,000,000">
                    <p class="field-hint">Provisional figure; confirm before publishing.</p>
                    @error('investment_min')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="auth-field">
                    <label for="investment_max" class="form-label-mia">Maximum investment <span class="opt">Optional</span></label>
                    <input type="text" id="investment_max" name="investment_max" maxlength="100"
                        class="form-control-mia @error('investment_max') is-invalid @enderror"
                        value="{{ old('investment_max', $opportunity->investment_max) }}"
                        placeholder="e.g. $35,000,000">
                    <p class="field-hint">Provisional figure; confirm before publishing.</p>
                    @error('investment_max')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="auth-field">
                    <label for="status" class="form-label-mia">Status <span class="req">*</span></label>
                    <select id="status" name="status" class="form-control-mia @error('status') is-invalid @enderror">
                        <option value="published">Published</option>
                        <option value="draft" @selected(old('status', $opportunity->status) === 'draft'>Draft</option>
                    </select>
                    @error('status')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="auth-field">
                    <label for="is_featured" class="form-label-mia">Featured <span class="opt">Optional</span></label>
                    <input type="checkbox" id="is_featured" name="is_featured" value="1"
                        @checked(old('is_featured', $opportunity->is_featured ?? false))
                        class="form-control-mia">
                    <p class="field-hint">Shows this opportunity on the homepage and featured listings.</p>
                </div>

                <div class="auth-field">
                    <label for="image_key" class="form-label-mia">Image key <span class="opt">Optional</span></label>
                    <input type="text" id="image_key" name="image_key" maxlength="80"
                        class="form-control-mia @error('image_key') is-invalid @enderror"
                        value="{{ old('image_key', $opportunity->image_key) }}"
                        placeholder="e.g. opportunities.city">
                    <p class="field-hint">Key in config/assets.php for the hero image.</p>
                    @error('image_key')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="auth-field">
                    <label for="sort_order" class="form-label-mia">Sort order</label>
                    <input type="number" id="sort_order" name="sort_order" min="0" max="9999"
                        class="form-control-mia @error('sort_order') is-invalid @enderror"
                        value="{{ old('sort_order', $opportunity->sort_order ?? 0) }}">
                    <p class="field-hint">Lower numbers appear first.</p>
                    @error('sort_order')<div class="form-error">{{ $message }}</div>@enderror
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
                    <input type="hidden" name="is_active" value="1">
                    <label class="admin-check" for="is_active">
                        <input type="checkbox" id="is_active" name="is_active" value="1"
                            checked>
                        <span>Published on public pages</span>
                    </label>
                </div>

                <div class="dash-form__actions">
                    <button type="submit" class="btn btn-mia btn-gold-mia">
                        {{ $opportunity->exists ? 'Save changes' : 'Add opportunity' }}
                    </button>
                    <a class="btn btn-mia btn-outline-mia" href="{{ route('admin.opportunities.index') }}">Cancel</a>
                </div>
            </div>
        </section>
    </aside>
</div>