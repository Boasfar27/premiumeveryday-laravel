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
        'type',
        'max_uses',
        'used_count',
        'expires_at',
        'is_active',
        'description',
    ];

    protected $casts = [
        'discount' => 'decimal:2',
        'max_uses' => 'integer',
        'used_count' => 'integer',
        'expires_at' => 'datetime',
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
     * Calculate the discount amount for a given subtotal.
     */
    public function calculateDiscount($subtotal): float
    {
        if ($this->type === 'percentage') {
            return ($subtotal * $this->discount) / 100;
        }

        return min($this->discount, $subtotal);
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
}
