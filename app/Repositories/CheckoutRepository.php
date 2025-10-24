<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderShipping;
use App\Repositories\CheckOutRepositoryInterface;

class CheckoutRepository implements CheckOutRepositoryInterface
{
    protected $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function createOrder(array $data)
    {
        return $this->model->create([
            'order_code' => 'ORDER-' . date('Ymd') . '-' . str_pad($this->model->count() + 1, 4, '0', STR_PAD_LEFT),
            'user_id' => $data['user_id'],
            'recipient_name' => $data['recipient_name'],
            'recipient_phone' => $data['recipient_phone'],
            'recipient_address' => $data['recipient_address'],
            'subtotal_amount' => $data['subtotal_amount'],
            'total_amount' => $data['total_amount'],
            'payment_method' => $data['payment_method'],
            'payment_status' => 'pending',
            'order_status' => 'pending',
        ]);
    }

    public function createOrderItems($orderId, array $items)
    {
        $orderItems = [];

        // Note: insert instead of foreach
        foreach ($items as $item) {
            $validatedItem = [
                'order_id' => $orderId,
                'product_id' => $item['product_id'] ?? null,
                'product_variant_id' => $item['product_variant_id'] ?? null,
                'snapshot_product_name' => $item['snapshot_product_name'] ?? 'Unknown',
                'snapshot_product_sku' => $item['snapshot_product_sku'] ?? 'N/A',
                'snapshot_product_price' => (float) ($item['snapshot_product_price'] ?? 0),
                'quantity' => (int) ($item['quantity'] ?? 0),
                'unit_price' => (float) ($item['unit_price'] ?? 0),
                'total_price' => (float) ($item['total_price'] ?? 0),
            ];

            $orderItem = OrderDetail::create($validatedItem);
            $orderItems[] = $orderItem;
        }

        return $orderItems;
    }

    public function findOrderByCode($orderCode)
    {
        return Order::with(['orderDetails', 'orderShipping'])
            ->where('order_code', $orderCode)
            ->first();
    }

    public function createOrderShipping(array $data)
    {
        $estimatedDelivery = now()->addDays(3);

        return OrderShipping::create([
            'order_id' => $data['order_id'],
            'shipping_method' => 'standard',
            'shipping_cost' => 1,
            'estimated_delivery_date' => $estimatedDelivery,
        ]);
    }
}
