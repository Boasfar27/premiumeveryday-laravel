<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MidtransTransaction extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'transaction_id',
        'payment_type',
        'gross_amount',
        'transaction_time',
        'transaction_status',
        'va_numbers',
        'fraud_status',
        'payment_code',
        'pdf_url',
        'status_code',
        'status_message',
        'snap_token',
        'redirect_url',
        'expiry_time',
        'payment_methods',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'gross_amount' => 'decimal:2',
        'transaction_time' => 'datetime',
        'va_numbers' => 'array',
        'expiry_time' => 'datetime',
        'payment_methods' => 'array',
    ];
    
    /**
     * Get the order that owns the transaction.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
