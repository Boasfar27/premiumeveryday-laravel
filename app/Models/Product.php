<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'type_sharing',
        'type_private',
        'price',
        'private_price',
        'image',
        'featured',
        'active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'private_price' => 'decimal:2',
        'featured' => 'boolean',
        'active' => 'boolean'
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset($this->image) : asset('images/placeholder.webp');
    }
}
