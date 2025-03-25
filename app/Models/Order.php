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
     * Get the Midtrans transaction for this order
     */
    public function midtransTransaction()
    {
        return $this->hasOne(MidtransTransaction::class);
    }

    /**
     * Get formatted payment status attribute for display
     */
    public function getFormattedStatusAttribute()
    {
        // Check order status first for rejected orders
        if ($this->status == 'rejected') {
            return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>';
        }
        
        // For other cases, check payment status first
        if ($this->payment_status == 'paid') {
            return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Pembayaran Selesai</span>';
        } else if ($this->payment_status == 'pending') {
            return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu Pembayaran</span>';
        } else if ($this->payment_status == 'failed') {
            return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Pembayaran Gagal</span>';
        } else if ($this->payment_status == 'expired') {
            return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Pembayaran Kadaluarsa</span>';
        } else {
            // Fallback status berdasarkan status order
            return match($this->status) {
                'approved' => '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>',
                'pending' => '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>',
                default => '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">'.ucfirst($this->status).'</span>',
            };
        }
    }

    /**
     * Get the status color attribute based on payment_status and order status.
     */
    public function getStatusColorAttribute()
    {
        // Prioritaskan warna berdasarkan payment_status jika ada kondisi khusus
        if (in_array($this->payment_status, ['failed', 'expired', 'refunded'])) {
            return match($this->payment_status) {
                'failed' => 'red',
                'expired' => 'gray',
                'refunded' => 'purple',
                default => 'gray',
            };
        }
        
        // Jika pembayaran pending, warna kuning
        if ($this->payment_status === 'pending') {
            return 'yellow';
        }
        
        // Jika pembayaran berhasil (paid), warna berdasarkan status order
        return match($this->status) {
            'pending' => 'blue',
            'approved' => 'green',
            'rejected' => 'red',
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
     * Scope a query to only include approved orders.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include pending orders.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include rejected orders.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
