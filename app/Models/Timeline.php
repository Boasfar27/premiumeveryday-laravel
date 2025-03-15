<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'icon',
        'is_active',
        'order'
    ];

    protected $casts = [
        'date' => 'datetime',
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    /**
     * Scope a query to only include active timelines.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
} 