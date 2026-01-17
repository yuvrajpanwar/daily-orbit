<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subscribers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'email',
        'status',
        'subscribed_at',
        'unsubscribed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status'          => 'boolean',
        'subscribed_at'   => 'datetime',
        'unsubscribed_at' => 'datetime',
        'created_at'      => 'datetime',
        'updated_at'      => 'datetime',
    ];

    /**
     * Default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => true,
    ];

    // ────────────────────────────────────────────────
    // Scopes (helpful query shortcuts)
    // ────────────────────────────────────────────────

    /**
     * Scope a query to only include active (subscribed) subscribers.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope a query to only include unsubscribed records.
     */
    public function scopeUnsubscribed($query)
    {
        return $query->where('status', false);
    }

    /**
     * Scope a query to get recently subscribed people.
     */
    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('subscribed_at', '>=', now()->subDays($days));
    }

    // ────────────────────────────────────────────────
    // Accessors / Mutators (optional but useful)
    // ────────────────────────────────────────────────

    /**
     * Get the subscription status as a human-readable string.
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->status ? 'Subscribed' : 'Unsubscribed';
    }

    /**
     * Check if the subscriber is currently active.
     */
    public function isActive(): bool
    {
        return $this->status === true;
    }

    /**
     * Check if the subscriber has unsubscribed.
     */
    public function hasUnsubscribed(): bool
    {
        return $this->status === false;
    }
}