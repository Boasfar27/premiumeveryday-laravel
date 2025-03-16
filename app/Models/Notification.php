<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'content',
        'image_url',
        'link',
        'is_public',
        'start_date',
        'end_date',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    /**
     * Notification types
     */
    const TYPE_SYSTEM = 'system';
    const TYPE_ORDER = 'order';
    const TYPE_SUBSCRIPTION = 'subscription';
    const TYPE_LICENSE = 'license';
    const TYPE_PAYMENT = 'payment';
    const TYPE_PROMOTION = 'promotion';

    /**
     * Get the users who have read this notification.
     */
    public function readers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'notification_reads')
            ->withPivot('read_at')
            ->withTimestamps();
    }

    /**
     * Mark notification as read by a user.
     */
    public function markAsReadBy(User $user): self
    {
        if (!$this->isReadBy($user)) {
            $this->readers()->attach($user->id, ['read_at' => now()]);
        }
        
        return $this;
    }

    /**
     * Check if notification is read by a user.
     */
    public function isReadBy(User $user): bool
    {
        return $this->readers()->where('user_id', $user->id)->exists();
    }

    /**
     * Scope a query to only include active notifications.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            });
    }

    /**
     * Scope a query to only include unread notifications for a user.
     */
    public function scopeUnreadByUser($query, $userId)
    {
        return $query->whereDoesntHave('readers', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    /**
     * Scope a query to only include public notifications.
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope a query to only include notifications of a specific type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
} 