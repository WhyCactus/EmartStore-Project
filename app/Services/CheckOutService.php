<?php

namespace App\Services;

use App\Http\Requests\CheckOutRequest;
use App\Repositories\CartRepositoryInterface;
use App\Repositories\CheckOutRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CheckOutService
{
    public function __construct(private CartRepositoryInterface $cartRepository, private CheckOutRepositoryInterface $orderRepository) {}

    public function getCheckOutData($userId)
    {
        $cart = $this->cartRepository->getUserCartById($userId);
        $cartItems = $this->cartRepository->getCartItems($userId);
        $cartTotal = $this->cartRepository->getCartTotal($userId);

        return [
            'cart' => $cart,
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal,
            'totalItems' => $cartItems->sum('quantity'),
        ];
    }

    public function processCheckOut($userId, array $checkOutData)
    {
        return DB::transaction(function () use ($userId, $checkOutData) {
            $cart = $this->cartRepository->getUserCartById($userId);
            $cartItems = $this->cartRepository->getCartItems($cart->id);

            if ($cartItems->isEmpty()) {
                throw new \Exception('Cart is empty.');
            }

            $subtotal = $cartItems->sum('total_price');
            $shippingCost = 1;
            $shippingMethod = 'standard';
            $totalAmount = $subtotal + $shippingCost;

            $order = $this->orderRepository->createOrder([
                'user_id' => $userId,
                'recipient_name' => $checkOutData['recipient_name'],
                'recipient_phone' => $checkOutData['recipient_phone'],
                'recipient_address' => $checkOutData['recipient_address'],
                'subtotal_amount' => $subtotal,
                'total_amount' => $totalAmount,
                'payment_method' => $checkOutData['payment_method'],
            ]);

            $orderItemsData = $cartItems
                ->map(function ($item) {
                    $product = $item->product;

                    $snapshotPrice = $item->unit_price ?? ($product->price ?? 0);
                    $snapshotName = $product->product_name ?? 'Unknown Product';
                    $snapshotSku = $product->sku ?? 'N/A';

                    return [
                        'product_id' => $item->product_id,
                        'product_variant_id' => $item->product_variant_id,
                        'snapshot_product_name' => $snapshotName,
                        'snapshot_product_sku' => $snapshotSku,
                        'snapshot_product_price' => (float) $snapshotPrice,
                        'quantity' => (int) $item->quantity,
                        'unit_price' => (float) ($item->unit_price ?? 0),
                        'total_price' => (float) ($item->total_price ?? 0),
                    ];
                })
                ->toArray();

            $this->orderRepository->createOrderItems($order->id, $orderItemsData);

            $this->orderRepository->createOrderShipping([
                'order_id' => $order->id,
                'shipping_method' => $shippingMethod,
                'shipping_cost' => $shippingCost,
            ]);

            $this->cartRepository->clearCart($cart->id);

            return $order;
        });
    }
}
