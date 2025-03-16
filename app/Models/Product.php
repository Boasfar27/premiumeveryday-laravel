<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @deprecated This model is deprecated and will be removed in future versions.
 * Use DigitalProduct and SubscriptionPlan models instead.
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'sharing_price',
        'private_price',
        'sharing_description',
        'private_description',
        'image',
        'is_active',
        'order',
        'sharing_discount',
        'private_discount',
        'is_promo',
        'promo_ends_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sharing_price' => 'decimal:2',
        'private_price' => 'decimal:2',
        'order' => 'integer',
        'sharing_discount' => 'integer',
        'private_discount' => 'integer',
        'is_promo' => 'boolean',
        'promo_ends_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $appends = ['image_url'];

    /**
     * Get the image URL attribute.
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? asset($this->image) : asset('images/placeholder.webp');
    }

    /**
     * Get the orders for the product.
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_items')
            ->withPivot('quantity', 'price', 'type') // type for sharing/private
            ->withTimestamps();
    }

    /**
     * Get the actual sharing price attribute.
     */
    public function getActualSharingPriceAttribute()
    {
        if ($this->is_promo && $this->promo_ends_at > now()) {
            return $this->sharing_price - ($this->sharing_price * $this->sharing_discount / 100);
        }
        return $this->sharing_price;
    }

    /**
     * Get the actual private price attribute.
     */
    public function getActualPrivatePriceAttribute()
    {
        if ($this->is_promo && $this->promo_ends_at > now()) {
            return $this->private_price - ($this->private_price * $this->private_discount / 100);
        }
        return $this->private_price;
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
