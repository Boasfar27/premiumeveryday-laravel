<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'sharing_price',
        'private_price',
        'sharing_description',
        'private_description',
        'image',
        'is_active',
        'order',
        'sharing_discount',
        'private_discount',
        'is_promo',
        'promo_ends_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sharing_price' => 'decimal:2',
        'private_price' => 'decimal:2',
        'order' => 'integer',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset($this->image) : asset('images/placeholder.webp');
    }
}
