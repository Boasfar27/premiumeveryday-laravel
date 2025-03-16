<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_plan_id',
        'name',
        'description',
        'icon',
        'is_highlighted',
        'sort_order',
    ];

    protected $casts = [
        'is_highlighted' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the subscription plan that owns the feature.
     */
    public function subscriptionPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    /**
     * Scope a query to only include highlighted features.
     */
    public function scopeHighlighted($query)
    {
        return $query->where('is_highlighted', true);
    }

    /**
     * Scope a query to order by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
