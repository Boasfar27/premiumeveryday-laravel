<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'avatar',
        'content',
        'rating',
        'user_id',
        'feedbackable_id',
        'feedbackable_type',
        'order_id',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'rating' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Get the user who left the feedback.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the feedbackable model (digital product or subscription plan).
     */
    public function feedbackable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the order associated with this feedback.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Scope a query to only include active feedback.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    /**
     * Scope a query to only include verified feedback (from registered users).
     */
    public function scopeVerified($query)
    {
        return $query->whereNotNull('user_id');
    }

    /**
     * Scope a query to only include feedback with a specific rating.
     */
    public function scopeWithRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Scope a query to only include feedback with a rating greater than or equal to a specific value.
     */
    public function scopeWithMinRating($query, $rating)
    {
        return $query->where('rating', '>=', $rating);
    }
}
