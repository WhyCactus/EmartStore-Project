<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_name',
        'sku',
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

    protected $casts = [
        'deleted_at'=> 'datetime',
        'updated_at'=> 'datetime',
        'created_at'=> 'datetime',
    ];

    protected $with = ['productVariants'];

    public function productVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

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

    public function getCurrentPriceAttribute()
    {
        if (
            $this->discounted_price &&
            $this->discounted_price > 0 &&
            $this->discounted_price < $this->original_price
        ) {
            return $this->discounted_price;
        }

        return $this->original_price;
    }

    public function getHasDiscountAttribute()
    {
        return $this->discounted_price &&
            $this->discounted_price > 0 &&
            $this->discounted_price < $this->original_price;
    }

}
