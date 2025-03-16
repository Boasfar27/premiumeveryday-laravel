<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'question',
        'answer',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    /**
     * FAQ categories
     */
    const CATEGORY_GENERAL = 'general';
    const CATEGORY_ACCOUNT = 'account';
    const CATEGORY_SUBSCRIPTION = 'subscription';
    const CATEGORY_PAYMENT = 'payment';
    const CATEGORY_PRODUCT = 'product';
    const CATEGORY_TECHNICAL = 'technical';

    /**
     * Get all available FAQ categories.
     */
    public static function categories(): array
    {
        return [
            self::CATEGORY_GENERAL => 'General',
            self::CATEGORY_ACCOUNT => 'Account',
            self::CATEGORY_SUBSCRIPTION => 'Subscription',
            self::CATEGORY_PAYMENT => 'Payment',
            self::CATEGORY_PRODUCT => 'Product',
            self::CATEGORY_TECHNICAL => 'Technical',
        ];
    }

    /**
     * Scope a query to only include active FAQs.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    /**
     * Scope a query to only include FAQs of a specific category.
     */
    public function scopeOfCategory($query, $category)
    {
        return $query->where('category', $category);
    }
} 