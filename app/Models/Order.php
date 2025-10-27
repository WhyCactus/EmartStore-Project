<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_code',
        'recipient_name',
        'recipient_phone',
        'recipient_address',
        'subtotal_amount',
        'total_amount',
        'payment_method',
        'payment_status',
        'order_status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function orderShipping()
    {
        return $this->hasOne(OrderShipping::class);
    }

    public function generateOrderCode()
    {
        return 'ORDER-' . date('Ymd') . '-' . str_pad($this->count() + 1, 4, '0', STR_PAD_LEFT);
    }
}
