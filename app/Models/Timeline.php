<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'description',
        'date',
        'icon',
        'color',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'date' => 'datetime',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Timeline types
     */
    const TYPE_GENERAL = 'general';
    const TYPE_PRODUCT = 'product';
    const TYPE_FEATURE = 'feature';
    const TYPE_UPDATE = 'update';
    const TYPE_PROMOTION = 'promotion';
    const TYPE_EVENT = 'event';

    /**
     * Get all available timeline types.
     */
    public static function types(): array
    {
        return [
            self::TYPE_GENERAL => 'General',
            self::TYPE_PRODUCT => 'Product Launch',
            self::TYPE_FEATURE => 'New Feature',
            self::TYPE_UPDATE => 'Update',
            self::TYPE_PROMOTION => 'Promotion',
            self::TYPE_EVENT => 'Event',
        ];
    }

    /**
     * Scope a query to only include active timelines.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Scope a query to only include timelines of a specific type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to only include timelines after a specific date.
     */
    public function scopeAfterDate($query, $date)
    {
        return $query->where('date', '>=', $date);
    }

    /**
     * Scope a query to only include timelines before a specific date.
     */
    public function scopeBeforeDate($query, $date)
    {
        return $query->where('date', '<=', $date);
    }

    /**
     * Scope a query to only include timelines between two dates.
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate);
    }
} 