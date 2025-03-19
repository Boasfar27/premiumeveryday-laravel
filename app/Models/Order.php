<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'order_type',
        'name',
        'email',
        'whatsapp',
        'subtotal',
        'tax',
        'shipping',
        'discount_amount',
        'total',
        'payment_method',
        'payment_status',
        'status',
        'payment_proof',
        'paid_at',
        'billing_details',
        'customer_notes',
        'admin_notes',
        'coupon_code',
        'payment_methods',
        'midtrans_url',
        'midtrans_token',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_at' => 'datetime',
        'billing_details' => 'array',
    ];

    protected $appends = ['status_color'];

    /**
     * Get the user that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items for the order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the user subscriptions for the order.
     */
    public function userSubscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class);
    }

    /**
     * Get the licenses for the order.
     */
    public function licenses(): HasMany
    {
        return $this->hasMany(DigitalProductLicense::class);
    }

    /**
     * Get the reviews for this order.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the Midtrans transaction for the order.
     */
    public function midtransTransaction()
    {
        return $this->hasOne(MidtransTransaction::class);
    }

    /**
     * Get the status color for the order.
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'processing' => 'info',
            'active' => 'success',
            'completed' => 'primary',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Get the formatted total for the order.
     */
    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    /**
     * Get the formatted status for the order.
     */
    public function getFormattedStatusAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu Pembayaran',
            'processing' => 'Diproses',
            'active' => 'Aktif',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => 'Unknown',
        };
    }

    /**
     * Calculate the order totals.
     */
    public function calculateTotals()
    {
        $this->subtotal = $this->items->sum('subtotal');
        $this->tax = $this->items->sum('tax');
        $this->total = $this->subtotal + $this->tax + $this->shipping - $this->discount_amount;
        
        return $this;
    }

    /**
     * Scope a query to only include active orders.
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['active', 'processing']);
    }

    /**
     * Scope a query to only include pending orders.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include completed orders.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include cancelled orders.
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }
}
