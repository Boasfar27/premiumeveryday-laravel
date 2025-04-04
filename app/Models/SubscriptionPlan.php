<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Setting;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'digital_product_id',
        'name',
        'slug',
        'description',
        'type',
        'max_users',
        'price',
        'sale_price',
        'billing_cycle',
        'duration_days',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'max_users' => 'integer',
        'duration_days' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the digital product that owns the subscription plan.
     */
    public function digitalProduct(): BelongsTo
    {
        return $this->belongsTo(DigitalProduct::class);
    }

    /**
     * Get the features for the subscription plan.
     */
    public function features(): HasMany
    {
        return $this->hasMany(SubscriptionFeature::class);
    }

    /**
     * Get the user subscriptions for the subscription plan.
     */
    public function userSubscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class);
    }

    /**
     * Get the order items for the subscription plan.
     */
    public function orderItems(): MorphMany
    {
        return $this->morphMany(OrderItem::class, 'orderable');
    }

    /**
     * Get the current price of the subscription plan.
     */
    public function getCurrentPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    /**
     * Get the formatted price with billing cycle.
     */
    public function getFormattedPriceAttribute()
    {
        $price = $this->getCurrentPriceAttribute();
        
        switch ($this->billing_cycle) {
            case 'monthly':
                return '$' . number_format($price, 2) . '/month';
            case 'quarterly':
                return '$' . number_format($price, 2) . '/quarter';
            case 'semi_annual':
                return '$' . number_format($price, 2) . '/6 months';
            case 'annual':
                return '$' . number_format($price, 2) . '/year';
            default:
                return '$' . number_format($price, 2);
        }
    }

    /**
     * Get the duration in days based on billing cycle.
     */
    public function getDurationInDaysAttribute()
    {
        if ($this->billing_cycle === 'one_time') {
            return $this->duration_days ?? 0;
        }
        
        switch ($this->billing_cycle) {
            case 'monthly':
                return 30;
            case 'quarterly':
                return 90;
            case 'semi_annual':
                return 180;
            case 'annual':
                return 365;
            default:
                return 0;
        }
    }

    /**
     * Scope a query to only include active plans.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured plans.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include individual plans.
     */
    public function scopeIndividual($query)
    {
        return $query->where('type', 'individual');
    }

    /**
     * Scope a query to only include sharing plans.
     */
    public function scopeSharing($query)
    {
        return $query->where('type', 'sharing');
    }

    /**
     * Get the included features for the subscription plan.
     */
    public function includedFeatures()
    {
        return $this->features()->where('is_included', true)->orderBy('sort_order');
    }

    /**
     * Get the excluded features for the subscription plan.
     */
    public function excludedFeatures()
    {
        return $this->features()->where('is_included', false)->orderBy('sort_order');
    }

    /**
     * Get the display name with duration.
     */
    public function getDisplayNameAttribute()
    {
        $durations = Setting::get('subscription_durations', []);
        $durationLabel = isset($durations[$this->billing_cycle]) ? $durations[$this->billing_cycle]['label'] : ucfirst($this->billing_cycle);
        
        return "{$this->name} - {$durationLabel}";
    }

    /**
     * Get the formatted price with currency.
     */
    public function getFormattedPriceWithCurrencyAttribute()
    {
        $currency = Setting::get('currency_symbol', 'Rp');
        return "{$currency} " . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get the formatted discount price with currency.
     */
    public function getFormattedDiscountPriceAttribute()
    {
        if ($this->sale_price <= 0) {
            return null;
        }
        
        $currency = Setting::get('currency_symbol', 'Rp');
        return "{$currency} " . number_format($this->sale_price, 0, ',', '.');
    }

    /**
     * Get the discount percentage.
     */
    public function getDiscountPercentageAttribute()
    {
        if ($this->sale_price > 0 && $this->price > 0) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        
        return 0;
    }

    /**
     * Get the duration in human-readable format.
     */
    public function getDurationLabelAttribute()
    {
        $durations = Setting::get('subscription_durations', []);
        return isset($durations[$this->billing_cycle]) ? $durations[$this->billing_cycle]['label'] : ucfirst($this->billing_cycle);
    }
}
