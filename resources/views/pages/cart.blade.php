@extends('layouts.app')

@section('title', 'Cart - E Shop')

@section('content')
    <!-- Cart Start -->
    <div class="cart-page">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @if (count($cart->items) > 0)
                                    @foreach ($cart->items as $item)
                                        <tr>
                                            <td><img src="{{ asset('storage/' . $item->product->image) }}" alt="Image">
                                            </td>
                                            <td><a href="#">{{ $item->product->product_name }}</a></td>
                                            <td class="unit-price">${{ number_format($item->unit_price, 2) }}</td>
                                            <td>
                                                <div class="qty">
                                                    <form action="{{ route('cart.updateItem', $item->id) }}" method="POST"
                                                        class="d-inline update-form">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" class="btn-minus"
                                                            data-item-id="{{ $item->id }}"
                                                            data-unit-price="{{ $item->unit_price }}">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                        <input type="text" name="quantity" value="{{ $item->quantity }}"
                                                            class="quantity-input" data-item-id="{{ $item->id }}"
                                                            data-unit-price="{{ $item->unit_price }}">
                                                        <button type="button" class="btn-plus"
                                                            data-item-id="{{ $item->id }}"
                                                            data-unit-price="{{ $item->unit_price }}">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="total-price" id="total-price-{{ $item->id }}">
                                                ${{ number_format($item->total_price, 2) }}
                                            </td>
                                            <td>
                                                <form action="{{ route('cart.removeItem', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Are you sure?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Your cart is empty</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if ($cart && $cart->items->count() > 0)
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="cart-summary">
                            <div class="cart-content">
                                <h3>Cart Summary</h3>
                                <?php
                                $subtotal = $cart->items->sum('total_price');
                                $shippingCost = 1;
                                $grandTotal = $subtotal + $shippingCost;
                                ?>
                                <p>Sub Total<span class="subtotal-amount">${{ number_format($subtotal, 2) }}</span></p>
                                <p>Shipping Cost<span class="shipping-cost">${{ number_format($shippingCost, 2) }}</span>
                                </p>
                                <h4>Grand Total<span class="grandtotal-amount">${{ number_format($grandTotal, 2) }}</span>
                                </h4>
                            </div>
                            <form action="{{ route('checkout') }}" method="GET">
                                <div class="cart-btn">
                                    <button type="submit" class="btn-checkout">Checkout</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- Cart End -->
@endsection
