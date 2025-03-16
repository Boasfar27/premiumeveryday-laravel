<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class DigitalProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'features',
        'requirements',
        'price',
        'sale_price',
        'is_on_sale',
        'sale_ends_at',
        'thumbnail',
        'gallery',
        'demo_url',
        'download_url',
        'download_count',
        'version',
        'product_type',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_on_sale' => 'boolean',
        'sale_ends_at' => 'datetime',
        'gallery' => 'array',
        'download_count' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the category that owns the digital product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the subscription plans for the digital product.
     */
    public function subscriptionPlans(): HasMany
    {
        return $this->hasMany(SubscriptionPlan::class);
    }

    /**
     * Get the licenses for the digital product.
     */
    public function licenses(): HasMany
    {
        return $this->hasMany(DigitalProductLicense::class);
    }

    /**
     * Get the order items for the digital product.
     */
    public function orderItems(): MorphMany
    {
        return $this->morphMany(OrderItem::class, 'orderable');
    }

    /**
     * Get the current price of the digital product.
     */
    public function getCurrentPriceAttribute()
    {
        if ($this->is_on_sale && $this->sale_ends_at > now()) {
            return $this->sale_price;
        }
        return $this->price;
    }

    /**
     * Get the thumbnail URL.
     */
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? asset($this->thumbnail) : asset('images/placeholder.webp');
    }

    /**
     * Get the image URL (alias for thumbnail_url for compatibility).
     */
    public function getImageUrlAttribute()
    {
        return $this->thumbnail_url;
    }

    /**
     * Get the sharing price (alias for price for compatibility).
     */
    public function getSharingPriceAttribute()
    {
        return $this->price;
    }

    /**
     * Get the actual sharing price after discount.
     */
    public function getActualSharingPriceAttribute()
    {
        return $this->current_price;
    }

    /**
     * Get the sharing discount percentage.
     */
    public function getSharingDiscountAttribute()
    {
        if ($this->is_on_sale && $this->sale_price < $this->price) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }

    /**
     * Check if the product is on promotion.
     */
    public function getIsPromoAttribute()
    {
        return $this->is_on_sale;
    }

    /**
     * Get the promotion end date.
     */
    public function getPromoEndsAtAttribute()
    {
        return $this->sale_ends_at;
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include products on sale.
     */
    public function scopeOnSale($query)
    {
        return $query->where('is_on_sale', true)
            ->where(function ($query) {
                $query->whereNull('sale_ends_at')
                    ->orWhere('sale_ends_at', '>', now());
            });
    }
}
