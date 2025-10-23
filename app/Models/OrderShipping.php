<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderShipping extends Model
{
    use SoftDeletes;

    protected $table = 'order_shipping';

    protected $fillable = [
        'order_id',
        'shipping_method',
        'shipping_cost',
        'note'
    ];

    protected $casts = [
        'estimated_delivery' => 'date',
        'actual_delivery' => 'datetime'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
