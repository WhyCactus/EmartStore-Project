<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function show(Request $request)
    {
        $userId = Auth::user()->id;
        if (!$userId) {
            return redirect()->route('login');
        }

        $cart = $this->cartRepository->getUserCartById($userId);

        if (!$cart) {
        $cart = new Cart(['user_id' => $userId]);
        $cart->items = collect();
    }

        return view('client.pages.cart', compact('cart'));
    }

    public function addItem(Request $request)
    {
        $item = $this->cartRepository->addItemToCart($request->user()->id, [
            'product_id' => $request->product_id,
            'product_variant_id' => $request->product_variant_id,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'total_price' => $request->total_price
        ]);

        return redirect()->route('cart.list')->with('success','Add item to cart successfully!');
    }

    public function updateItem(Request $request, $cartItemId)
    {
        $item = $this->cartRepository->updateCartItem($cartItemId, $request->quantity);
        return redirect()->route('cart.list')->with('success','Add item to cart successfully!');
    }

    public function removeItem($cartItemId)
    {
        $item = $this->cartRepository->removeItemItem($cartItemId);
        return redirect()->route('cart.list')->with('success','Remove item from cart successfully!');
    }

    public function clear()
    {
        $this->cartRepository->clearCart(Auth::user()->id);
        return redirect()->route('')->with('success','');
    }
}
