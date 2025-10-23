<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;

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
