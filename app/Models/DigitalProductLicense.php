<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DigitalProductLicense extends Model
{
    use HasFactory;

    protected $fillable = [
        'digital_product_id',
        'user_id',
        'order_id',
        'license_key',
        'status',
        'assigned_at',
        'activated_at',
        'expires_at',
        'max_activations',
        'activation_count',
        'notes',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'activated_at' => 'datetime',
        'expires_at' => 'datetime',
        'max_activations' => 'integer',
        'activation_count' => 'integer',
    ];

    /**
     * Get the digital product that owns the license.
     */
    public function digitalProduct(): BelongsTo
    {
        return $this->belongsTo(DigitalProduct::class);
    }

    /**
     * Get the user that owns the license.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order that owns the license.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Check if the license is active.
     */
    public function isActive()
    {
        return $this->status === 'assigned' && 
               ($this->expires_at === null || $this->expires_at > now()) &&
               ($this->max_activations === 0 || $this->activation_count < $this->max_activations);
    }

    /**
     * Check if the license is expired.
     */
    public function isExpired()
    {
        return $this->expires_at !== null && $this->expires_at <= now();
    }

    /**
     * Check if the license has reached maximum activations.
     */
    public function hasReachedMaxActivations()
    {
        return $this->max_activations > 0 && $this->activation_count >= $this->max_activations;
    }

    /**
     * Increment the activation count.
     */
    public function incrementActivationCount()
    {
        $this->activation_count++;
        $this->save();
        
        return $this;
    }

    /**
     * Scope a query to only include available licenses.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope a query to only include assigned licenses.
     */
    public function scopeAssigned($query)
    {
        return $query->where('status', 'assigned');
    }

    /**
     * Scope a query to only include active licenses.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'assigned')
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->where(function ($query) {
                $query->where('max_activations', 0)
                    ->orWhereRaw('activation_count < max_activations');
            });
    }
}
