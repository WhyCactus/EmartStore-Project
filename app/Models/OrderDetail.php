<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id',
        'snapshot_product_name',
        'snapshot_product_sku',
        'snapshot_product_price',
        'snapshot_variant_attributes',
        'quantity',
        'unit_price',
        'total_price'];

    protected $casts = [
        'snapshot_product_price' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'quantity'=> 'integer',
    ];

    protected $attributes = [
        'snapshot_product_price' => 0,
        'unit_price' => 0,
        'total_price' => 0,
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function getVariantAttributesAttribute()
    {
        return $this->snapshot_variant_attributes ? json_decode($this->snapshot_variant_attributes, true) : null;
    }
}
