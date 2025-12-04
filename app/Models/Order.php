<?php

namespace App\Models;

use App\Constants\OrderStatus;
use App\Constants\PaymentStatus;
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
        'order_status',
        'cancelled_at',
        'cancellation_reason',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'cancelled_at' => 'datetime'
    ];

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

    public function productVariants()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function generateOrderCode()
    {
        return 'ORDER-' . date('Ymd') . '-' . str_pad($this->count() + 1, 4, '0', STR_PAD_LEFT);
    }

    public function scopePending($query)
    {
        return $query->where('order_status', 'pending');
    }

    public function scopeExpired($query, $minutes = 15)
    {
        return $query->where('payment_method', 'stripe')
            ->where('payment_status', PaymentStatus::PENDING)
            ->where('order_status', OrderStatus::PENDING)
            ->where('created_at', '<=', now()->subMinutes($minutes));
    }
}
