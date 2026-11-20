<?php

namespace App\Models;

use Database\Factories\NewsPostFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsPost extends Model
{
    /** @use HasFactory<NewsPostFactory> */
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'excerpt',
        'body',
        'category',
        'image_key',
        'is_featured',
        'published_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Published posts, newest first.
     *
     * @param  Builder<NewsPost>  $query
     * @return Builder<NewsPost>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')->orderByDesc('published_at');
    }

    /**
     * Image manifest entry for this post.
     *
     * @return array{path: string, alt: string}|null
     */
    public function image(): ?array
    {
        $key = (string) $this->image_key;

        return $key !== '' ? (config('assets.'.$this->image_key) ?? null) : null;
    }
}
