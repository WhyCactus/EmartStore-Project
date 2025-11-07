<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = [
        'variant_id',
        'attribute_name',
        'attribute_value',
    ] ;

    public function variants()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
