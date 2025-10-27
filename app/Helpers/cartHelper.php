<?php

namespace App\Helpers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class cartHelper
{
    public static function getCart()
    {
        $userId = Auth::user()->id;
        return Cart::firstOrCreate(['user_id' => $userId]);
    }

    public static function getCartItems()
    {
        $cart = Auth::user()->id;
        return $cart->cartItems()->which(['product','productVariant'])->get();
    }

    public static function getCartTotal()
    {
        return self::getCartItems()->sum('total_price');
    }

    public static function getTotalItems()
    {
        return self::getCartItems()->sum('quantity');
    }

    public static function getCartData()
    {
        $cartItems = self::getCartItems();
        return [
            'items'=> $cartItems,
            'total' => $cartItems->sum('total_price'),
            'totalItems' => $cartItems->sum('quantity'),
            'cart_id' => self::getCart()->id
        ];
    }
}
