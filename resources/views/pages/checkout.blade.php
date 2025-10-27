@extends('layouts.app')

@section('title', 'Checkout - E Shop')

@section('content')
    <!-- Checkout Start -->
    <div class="checkout">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="container">
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-7">
                        <div class="billing-address">
                            <h2>Billing Address</h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Full Name</label>
                                    <input class="form-control" type="text" name="recipient_name" required
                                        value="{{ old('recipient_name', Auth::user()->username) }}">
                                    @error('')
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label>Phone Number</label>
                                    <input class="form-control" type="text" name="recipient_phone" required
                                        value="{{ old('recipient_phone', Auth::user()->phone) }}">
                                </div>
                                <div class="col-md-12">
                                    <label>Address</label>
                                    <textarea name="recipient_address" class="form-control" rows="3" placeholder="Address" required>{{ old('recipient_address') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="checkout-summary">
                            <h2>Cart Total</h2>
                            <div class="checkout-content">
                                <h3>Products</h3>

                                @foreach ($cartItems as $item)
                                    <p>
                                        {{ $item->product->product_name }}
                                        @if ($item->productVariant)
                                            ({{ $item->productVariant->name }})
                                        @endif
                                        x {{ $item->quantity }}
                                        <span>{{ number_format($item->total_price) }}$</span>
                                    </p>
                                @endforeach

                                <p class="sub-total">Sub Total<span id="sub-total">{{ number_format($cartTotal) }}₫</span>
                                </p>
                                <p class="ship-cost">Shipping Cost<span id="shipping-cost">1$</span></p>
                                <h4>Grand Total<span id="grand-total">{{ number_format($cartTotal + 1) }}$</span></h4>
                            </div>
                        </div>

                        <div class="checkout-payment">
                            <h2>Payment Methods</h2>
                            <div class="payment-methods">
                                <div class="payment-method">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="payment-1"
                                            name="payment_method" value="cash"
                                            {{ old('payment_method') == 'cash' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="payment-1">Cash</label>
                                    </div>
                                    <div class="payment-content" id="payment-1-show">
                                        <p>
                                            Cash on Delivery
                                        </p>
                                    </div>
                                </div>
                                @error('payment_method')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="checkout-btn">
                                <button type="submit">Place Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Checkout End -->
@endsection
