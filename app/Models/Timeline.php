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
} 