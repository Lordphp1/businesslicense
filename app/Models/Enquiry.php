<?php

namespace App\Models;

use Database\Factories\EnquiryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enquiry extends Model
{
    /** @use HasFactory<EnquiryFactory> */
    use HasFactory;

    public const STATUSES = ['new', 'assigned', 'closed'];

    protected $fillable = [
        'user_id',
        'assigned_to',
        'name',
        'email',
        'phone',
        'country',
        'subject',
        'industry_id',
        'message',
        'status',
        'source',
        'handled_at',
    ];

    protected $casts = [
        'handled_at' => 'datetime',
    ];

    /**
     * Investor account that submitted this enquiry, when authenticated.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Staff member currently handling this enquiry.
     *
     * @return BelongsTo<User, $this>
     */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Sector the enquiry relates to, if any.
     *
     * @return BelongsTo<Industry, $this>
     */
    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    /**
     * Internal notes recorded by the advisory desk, oldest first so the file
     * reads as a chronological log.
     *
     * @return HasMany<EnquiryNote, $this>
     */
    public function notes(): HasMany
    {
        return $this->hasMany(EnquiryNote::class)->oldest();
    }
}
