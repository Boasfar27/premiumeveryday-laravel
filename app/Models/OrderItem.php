<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'orderable_id',
        'orderable_type',
        'name',
        'quantity',
        'unit_price',
        'subtotal',
        'discount',
        'tax',
        'total',
        'options',
        'price',
        'subscription_type',
        'duration',
        'account_type',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'options' => 'array',
        'price' => 'decimal:2',
        'duration' => 'integer',
    ];
    
    protected $appends = ['formatted_price', 'formatted_total'];

    /**
     * Get the order that owns the item.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the owning orderable model.
     */
    public function orderable(): MorphTo
    {
        return $this->morphTo();
    }
    
    /**
     * Get the formatted price attribute.
     */
    public function getFormattedPriceAttribute()
    {
        $price = $this->price ?? $this->unit_price ?? 0;
        return 'Rp ' . number_format($price, 0, ',', '.');
    }
    
    /**
     * Get the formatted total attribute.
     */
    public function getFormattedTotalAttribute()
    {
        // Jika total sudah disimpan di database, gunakan nilai tersebut
        if ($this->total > 0) {
            return 'Rp ' . number_format($this->total, 0, ',', '.');
        }
        
        // Jika tidak, hitung total termasuk pajak
        $price = $this->price ?? $this->unit_price ?? 0;
        $quantity = $this->quantity ?? 1;
        
        // Total = price * quantity (pajak sudah termasuk dalam total order, bukan per item)
        $totalItem = $price * $quantity;
        
        return 'Rp ' . number_format($totalItem, 0, ',', '.');
    }
    
    /**
     * Get a new accessor to show subtotal without tax
     */
    public function getFormattedSubtotalAttribute()
    {
        $price = $this->price ?? $this->unit_price ?? 0;
        $quantity = $this->quantity ?? 1;
        return 'Rp ' . number_format($price * $quantity, 0, ',', '.');
    }
    
    /**
     * Get the price attribute with fallback.
     */
    public function getPriceAttribute($value)
    {
        return $value > 0 ? $value : ($this->unit_price ?? 0);
    }
    
    /**
     * Get the subscription_type attribute with fallback.
     */
    public function getSubscriptionTypeAttribute($value)
    {
        if (empty($value) || !in_array(strtolower($value), ['private', 'sharing'])) {
            return 'sharing';
        }
        return strtolower($value);
    }

    /**
     * Calculate the subtotal.
     */
    public function calculateSubtotal()
    {
        $price = $this->price ?? $this->unit_price ?? 0;
        $this->subtotal = $price * $this->quantity;
        return $this;
    }

    /**
     * Calculate the total.
     */
    public function calculateTotal()
    {
        $this->total = $this->subtotal - $this->discount + $this->tax;
        return $this;
    }
}
