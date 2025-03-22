<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionPlanFeature extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'subscription_plan_id',
        'name',
        'description',
        'is_included',
        'sort_order',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_included' => 'boolean',
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
     * Scope a query to only include included features.
     */
    public function scopeIncluded($query)
    {
        return $query->where('is_included', true);
    }
    
    /**
     * Scope a query to only include excluded features.
     */
    public function scopeExcluded($query)
    {
        return $query->where('is_included', false);
    }
} 