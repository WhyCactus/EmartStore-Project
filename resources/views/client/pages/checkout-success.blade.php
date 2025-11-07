@extends('client.layouts.app')

@section('title', 'Order Success - E Shop')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">🎉 Order Placed Successfully!</h4>
                    </div>
                    <div class="card-body text-center">
                        <h5>Thank you for your order!</h5>
                        <p class="text-muted">Your order has been placed successfully and is being processed.</p>

                        <div class="order-details mt-4">
                            <p><strong>Order Code:</strong> {{ $order->order_code }}</p>
                            <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
                            <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                            <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                            <p><strong>Shipping Address:</strong> {{ $order->recipient_address }}</p>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('home') }}" class="btn btn-primary me-2">
                                Continue Shopping
                            </a>
                            <a href="{{ route('my-account.order', $order->id) }}" class="btn btn-outline-secondary">
                                View Order Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
