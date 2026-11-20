{{-- Shared create/edit form. Expects $post (existing or new model). --}}
<div class="admin-detail">
    <div class="admin-detail__main">
        <section class="dash-block">
            <div class="dash-block__head">
                <h2>News post details</h2>
            </div>

            <div class="dash-form">
                <div class="auth-field">
                    <label for="title" class="form-label-mia">Title <span class="req">*</span></label>
                    <input type="text" id="title" name="title" maxlength="200" required
                        class="form-control-mia @error('title') is-invalid @enderror"
                        value="{{ old('title', $post->title) }}">
                    @error('title')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="auth-field">
                    <label for="excerpt" class="form-label-mia">Excerpt <span class="req">*</span></label>
                    <textarea id="excerpt" name="excerpt" rows="3" maxlength="300"
                        class="form-control-mia @error('excerpt') is-invalid @enderror"
                        placeholder="Brief summary for the listing page.">{{ old('excerpt', $post->excerpt) }}</textarea>
                    @error('excerpt')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="auth-field">
                    <label for="body" class="form-label-mia">Body <span class="req">*</span></label>
                    <textarea id="body" name="body" rows="5" maxlength="10000"
                        class="form-control-mia @error('body') is-invalid @enderror"
                        placeholder="Full editorial content...">{{ old('body', $post->body) }}</textarea>
                    @error('body')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="auth-field">
                    <label for="category" class="form-label-mia">Category <span class="req">*</span></label>
                    <select id="category" name="category" class="form-control-mia @error('category') is-invalid @enderror">
                        <option value="news">News</option>
                        <option value="press-release" @selected(old('category', $post->category) === 'press-release'>Press release</option>
                        <option value="publication" @selected(old('category', $post->category) === 'publication'>Publication</option>
                    </select>
                    @error('category')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="auth-field">
                    <label for="image_key" class="form-label-mia">Image key <span class="opt">Optional</span></label>
                    <input type="text" id="image_key" name="image_key" maxlength="80"
                        class="form-control-mia @error('image_key') is-invalid @enderror"
                        value="{{ old('image_key', $post->image_key) }}"
                        placeholder="e.g. news.newspaper">
                    <p class="field-hint">Key in config/assets.php for the article image.</p>
                    @error('image_key')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="auth-field">
                    <label for="is_featured" class="form-label-mia">Featured <span class="opt">Optional</span></label>
                    <input type="checkbox" id="is_featured" name="is_featured" value="1"
                        @checked(old('is_featured', $post->is_featured ?? false))
                        class="form-control-mia">
                    <p class="field-hint">Shows this post on the homepage and featured listings.</p>
                </div>

                <div class="auth-field">
                    <label for="published_at" class="form-label-mia">Published at <span class="opt">Optional</span></label>
                    <input type="date" id="published_at" name="published_at"
                        class="form-control-mia @error('published_at') is-invalid @enderror"
                        value="{{ old('published_at', $post->published_at?->format('Y-m-d') ?? '') }}">
                    <p class="field-hint">Leave blank for draft; set a date for published posts.</p>
                    @error('published_at')<div class="form-error">{{ $message }}</div>@enderror
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
                        <span>Active on public site</span>
                    </label>
                </div>

                <div class="dash-form__actions">
                    <button type="submit" class="btn btn-mia btn-gold-mia">
                        {{ $post->exists ? 'Save changes' : 'Add post' }}
                    </button>
                    <a class="btn btn-mia btn-outline-mia" href="{{ route('admin.news.index') }}">Cancel</a>
                </div>
            </div>
        </section>
    </aside>
</div>