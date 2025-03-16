<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

class UserSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'order_id',
        'subscription_number',
        'status',
        'starts_at',
        'expires_at',
        'auto_renew',
        'access_credentials',
        'notes',
        'cancellation_reason',
        'cancelled_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'auto_renew' => 'boolean',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Get the user that owns the subscription.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subscription plan that owns the subscription.
     */
    public function subscriptionPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    /**
     * Get the order that owns the subscription.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the decrypted access credentials.
     */
    public function getDecryptedCredentialsAttribute()
    {
        if ($this->access_credentials) {
            return Crypt::decrypt($this->access_credentials);
        }
        return null;
    }

    /**
     * Set the encrypted access credentials.
     */
    public function setAccessCredentialsAttribute($value)
    {
        $this->attributes['access_credentials'] = $value ? Crypt::encrypt($value) : null;
    }

    /**
     * Check if the subscription is active.
     */
    public function isActive()
    {
        return $this->status === 'active' && 
               $this->starts_at <= now() && 
               ($this->expires_at === null || $this->expires_at > now());
    }

    /**
     * Check if the subscription is expired.
     */
    public function isExpired()
    {
        return $this->expires_at !== null && $this->expires_at <= now();
    }

    /**
     * Check if the subscription is about to expire.
     */
    public function isAboutToExpire($days = 7)
    {
        return $this->expires_at !== null && 
               $this->expires_at > now() && 
               $this->expires_at <= now()->addDays($days);
    }

    /**
     * Scope a query to only include active subscriptions.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('starts_at', '<=', now())
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    /**
     * Scope a query to only include expired subscriptions.
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }

    /**
     * Scope a query to only include subscriptions about to expire.
     */
    public function scopeAboutToExpire($query, $days = 7)
    {
        return $query->where('status', 'active')
            ->whereNotNull('expires_at')
            ->where('expires_at', '>', now())
            ->where('expires_at', '<=', now()->addDays($days));
    }
}
