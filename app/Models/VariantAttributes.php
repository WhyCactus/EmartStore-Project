<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VariantAttributes extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_variant_id',
        'attribute_id',
        'value',
    ];

    public function products()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
}
