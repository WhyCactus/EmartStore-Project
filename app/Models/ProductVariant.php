<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'quantity_in_stock',
        'image',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributes()
    {
        return $this->hasMany(VariantAttributes::class, 'product_variant_id');
    }

    public function getAttributesMapAttribute()
    {
        return $this->attributes->pluck('attribute_value', 'attribute_name');
    }

    public function getFullNameAttribute()
    {
        $attrs = $this->attributes->pluck('attribute_value')->implode(' - ');
        return $this->product()->product_name . ($attrs ? ' - ' . $attrs : '');
    }
}
