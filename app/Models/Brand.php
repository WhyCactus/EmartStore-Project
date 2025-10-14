<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'brand_name',
        'status',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getBrandCountAttribute()
    {
        return $this->products()->count();
    }
}
