<?php

namespace App\Models;

use Database\Factories\IndustryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Industry extends Model
{
    /** @use HasFactory<IndustryFactory> */
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'icon',
        'summary',
        'image_key',
        'is_priority',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_priority' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Investment opportunities within this industry.
     *
     * @return HasMany<InvestmentOpportunity, $this>
     */
    public function opportunities(): HasMany
    {
        return $this->hasMany(InvestmentOpportunity::class);
    }

    /**
     * Image manifest entry for this industry.
     *
     * @return array{path: string, alt: string}|null
     */
    public function image(): ?array
    {
        $key = (string) $this->image_key;

        return $key !== '' ? (config('assets.'.$this->image_key) ?? null) : null;
    }
}
