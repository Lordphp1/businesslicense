<?php

namespace App\Models;

use Database\Factories\InvestmentOpportunityFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestmentOpportunity extends Model
{
    /** @use HasFactory<InvestmentOpportunityFactory> */
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'summary',
        'industry_id',
        'location',
        'investment_min',
        'investment_max',
        'status',
        'is_featured',
        'image_key',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    /**
     * Sector this opportunity belongs to.
     *
     * @return BelongsTo<Industry, $this>
     */
    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    /**
     * Published opportunities, most relevant first.
     *
     * @param  Builder<InvestmentOpportunity>  $query
     * @return Builder<InvestmentOpportunity>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')->orderBy('sort_order');
    }

    /**
     * Image manifest entry for this opportunity.
     *
     * @return array{path: string, alt: string}|null
     */
    public function image(): ?array
    {
        $key = (string) $this->image_key;

        return $key !== '' ? (config('assets.'.$this->image_key) ?? null) : null;
    }
}
