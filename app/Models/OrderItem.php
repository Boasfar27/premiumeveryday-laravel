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
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'options' => 'array',
    ];

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
     * Calculate the subtotal.
     */
    public function calculateSubtotal()
    {
        $this->subtotal = $this->unit_price * $this->quantity;
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
