<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'category_name',
        'image',
        'status'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getProductCountAttribute()
    {
        return $this->products()->count();
    }
}
