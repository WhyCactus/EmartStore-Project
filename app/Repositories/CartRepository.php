<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\CartItem;

class CartRepository implements CartRepositoryInterface
{
    public function getUserCartById($userId)
    {
        return Cart::where('user_id', $userId)->first();
    }

    public function addItemToCart($userId, $itemData)
    {
        $cart = Cart::firstOrCreate(['user_id' => $userId]);

        $quantity = $itemData['quantity'];
        $unitPriced = $itemData['unit_price'];
        $totalPrice = $unitPriced * $quantity;

        $exitingItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $itemData['product_id'])
            ->where('product_variant_id', $itemData['product_variant_id'] ?? null)
            ->first();

        if ($exitingItem) {
            $exitingItem->quantity += $itemData['quantity'];
            $exitingItem->total_price = $exitingItem->quantity * $exitingItem->unit_price;
            $exitingItem->save();
            return $exitingItem;
        }

        return CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $itemData['product_id'],
            'product_variant_id' => $itemData['product_variant_id'],
            'quantity' => $quantity,
            'unit_price' => $unitPriced,
            'total_price' => $totalPrice
        ]);
    }

    public function updateCartItem($cartItemId, $quantity)
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        $cartItem->quantity = $quantity;
        $cartItem->total_price = $cartItem->quantity * $cartItem->unit_price;
        $cartItem->save();
        return $cartItem;
    }

    public function removeItemItem($cartItemId)
    {
        return CartItem::destroy($cartItemId);
    }

    public function clearCart($userId)
    {
        $cart = Cart::where('user_id', $userId)->first();
        if ($cart) {
            return $cart->items()->delete();
        }
        return false;
    }
}
