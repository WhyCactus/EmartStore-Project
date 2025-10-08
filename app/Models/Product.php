<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'product_name',
        'product_code',
        'image',
        'description',
        'original_price',
        'discounted_price',
        'status',
        'category_id',
        'brand_id',
        'quantity_in_stock',
        'sold_count'
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }


    // Accessor for reviews count
    public function getReviewsCountAttribute(): int
    {
        return $this->reviews()->count();
    }

    // Check if product is on sale
    public function getIsOnSaleAttribute(): bool
    {
        return $this->discounted_price && $this->discounted_price < $this->original_price;
    }

    // Calculate discount percentage
    public function getDiscountPercentageAttribute(): float
    {
        if (!$this->is_on_sale)
            return 0;

        return round((($this->original_price - $this->discounted_price) / $this->original_price) * 100);
    }

}
