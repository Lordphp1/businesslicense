<?php

namespace App\Models;

use Database\Factories\PermitFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permit extends Model
{
    /** @use HasFactory<PermitFactory> */
    use HasFactory;

    /**
     * Symbols used when presenting a fee. Other ISO codes fall back to "CODE amount".
     *
     * @var array<string, string>
     */
    public const CURRENCY_SYMBOLS = [
        'USD' => '$',
        'GBP' => '£',
        'EUR' => '€',
        'NGN' => '₦',
        'CAD' => 'CA$',
        'AUD' => 'A$',
    ];

    protected $fillable = [
        'slug',
        'name',
        'authority',
        'summary',
        'fee',
        'currency',
        'turnaround',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'fee' => 'decimal:2',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Permits published on the public site, in display order.
     *
     * @param  Builder<Permit>  $query
     * @return Builder<Permit>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name');
    }

    /**
     * Agency fee with its currency, or null when the fee is quoted on assessment.
     */
    public function formattedFee(): ?string
    {
        if ($this->fee === null) {
            return null;
        }

        $currency = strtoupper((string) $this->currency);
        $amount = number_format((float) $this->fee, 2, '.', ',');

        if (str_ends_with($amount, '.00')) {
            $amount = substr($amount, 0, -3);
        }

        return (self::CURRENCY_SYMBOLS[$currency] ?? $currency.' ').$amount;
    }
}
