<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount',
        'value',
        'type',
        'max_uses',
        'used_count',
        'expires_at',
        'start_date',
        'is_active',
        'description',
        'max_discount',
        'min_purchase',
    ];

    protected $casts = [
        'discount' => 'decimal:2',
        'value' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'max_uses' => 'integer',
        'used_count' => 'integer',
        'expires_at' => 'datetime',
        'start_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the orders that used this coupon.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'coupon_code', 'code');
    }

    /**
     * Check if the coupon is valid.
     */
    public function isValid(): bool
    {
        // Check if coupon is active
        if (!$this->is_active) {
            return false;
        }

        // Check if coupon has expired
        if ($this->expires_at && $this->expires_at < now()) {
            return false;
        }

        // Check if coupon has reached max uses
        if ($this->max_uses && $this->used_count >= $this->max_uses) {
            return false;
        }

        return true;
    }

    /**
     * Get the discount value to use (value or discount).
     * Prioritizes 'value' field but falls back to 'discount' if value is null
     */
    public function getDiscountValue()
    {
        return $this->value ?? $this->discount ?? 0;
    }

    /**
     * Calculate the discount amount for a given subtotal.
     */
    public function calculateDiscount($subtotal): float
    {
        // Get discount value from either column
        $discountValue = $this->getDiscountValue();
        
        // For percentage discount
        if ($this->type === 'percentage') {
            $calculated = ($subtotal * $discountValue) / 100;
            // Apply max_discount if set
            if (isset($this->max_discount) && $this->max_discount > 0) {
                $calculated = min($calculated, $this->max_discount);
            }
            return $calculated;
        }

        // For fixed amount, use the min between discount value and subtotal
        return min($discountValue, $subtotal);
    }

    /**
     * Increment the used count.
     */
    public function incrementUsedCount(): self
    {
        $this->used_count++;
        $this->save();
        
        return $this;
    }

    /**
     * Scope a query to only include active coupons.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include valid coupons.
     */
    public function scopeValid($query)
    {
        return $query->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->where(function ($query) {
                $query->whereNull('max_uses')
                    ->orWhereRaw('used_count < max_uses');
            });
    }

    /**
     * Check if the coupon has expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at < now();
    }
    
    /**
     * Check if the coupon has reached its usage limit.
     */
    public function hasReachedUsageLimit(): bool
    {
        return $this->max_uses && $this->used_count >= $this->max_uses;
    }
}
