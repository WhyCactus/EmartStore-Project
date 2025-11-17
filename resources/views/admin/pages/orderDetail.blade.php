@extends('admin.layouts.app')

@section('title', 'Oder Detail - Emart Admin')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">{{ $order->order_code }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.orders') }}">Orders</a></li>
            <li class="breadcrumb-item active">{{ $order->order_code }}</li>
    </div>
    <div class="container py-2">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Order Details</h2>
            <a href="{{ route('admin.orders') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Orders
            </a>
        </div>

        <div class="card p-4">
            <div class="row">
                <!-- Order Items Section -->
                <div class="col-lg-8 mb-4">
                    <div class="card-header mb-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-cart-check me-2"></i>
                            <span>Order Items</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col" class="ps-4">Product</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col" class="text-end pe-4">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderDetails as $orderDetail)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="product-img me-3">
                                                        <i class="bi bi-box"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium">{{ $orderDetail->snapshot_product_name }}
                                                        </div>
                                                        @if ($orderDetail->variant_attributes)
                                                            <small class="text-muted d-block">
                                                                @foreach ($orderDetail->variant_attributes as $attr)
                                                                    <span class="badge bg-light text-dark me-1">{{ $attr['name'] }}: {{ $attr['value'] }}</span>
                                                                @endforeach
                                                            </small>
                                                        @endif
                                                        <small class="text-muted">SKU:
                                                            {{ $orderDetail->snapshot_product_sku ?? 'N/A' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>${{ number_format($orderDetail->unit_price, 2) }}</td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $orderDetail->quantity }}</span>
                                            </td>
                                            <td class="text-end fw-medium pe-4">
                                                ${{ number_format($orderDetail->total_price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Order Summary & Information -->
                <div class="col-lg-4">
                    <!-- Order Summary -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-receipt me-2"></i>
                                <span>Order Summary</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal:</span>
                                <span>${{ number_format($order->subtotal_amount, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Shipping:</span>
                                <span>${{ number_format($order->orderShipping->shipping_cost, 2) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold total-amount">
                                <span>Total:</span>
                                <span>${{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- General Order Information -->
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-info-circle me-2"></i>
                                <span>Order Information</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="info-label mb-1">Order ID</div>
                                <div class="fw-medium">#{{ $order->id }}</div>
                            </div>
                            <div class="mb-3">
                                <div class="info-label mb-1">Order Date</div>
                                <div class="fw-medium">{{ $order->created_at->format('M d, Y') }}</div>
                            </div>
                            <div class="mb-3">
                                <div class="info-label mb-1">Customer Name</div>
                                <div class="fw-medium">{{ $order->recipient_name }}</div>
                            </div>
                            <div class="mb-3">
                                <div class="info-label mb-1">Contact Info</div>
                                <div class="fw-medium">{{ $order->recipient_phone }}</div>
                            </div>
                            <div class="mb-3">
                                <div class="info-label mb-1">Shipping Address</div>
                                <div class="fw-medium">{{ $order->recipient_address }}</div>
                            </div>
                            <div class="mb-3">
                                <div class="info-label mb-1">Payment Method</div>
                                <div class="fw-medium">
                                    <i class="bi bi-credit-card me-1"></i>
                                    {{ $order->payment_method }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="info-label mb-1">Payment Status</div>
                                <div class="fw-medium">
                                    {{ $order->payment_status }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="info-label mb-1">Current Status</div>
                                <div>
                                    @php
                                        $statusClass = 'status-pending';
                                        if ($order->order_status == 'Processing') {
                                            $statusClass = 'status-processing';
                                        } elseif ($order->order_status == 'Shipped') {
                                            $statusClass = 'status-shipped';
                                        } elseif ($order->order_status == 'Delivered') {
                                            $statusClass = 'status-delivered';
                                        } elseif ($order->order_status == 'Cancelled') {
                                            $statusClass = 'status-cancelled';
                                        }
                                    @endphp
                                    <span class="order-status {{ $statusClass }}">{{ $order->order_status }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <div class="d-flex align-content-center">
                        <i class="bi bi-repeat"></i>
                        <span>Update Status</span>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.update-status', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">New Status</label>
                                    <select name="order_status" class="form-select">
                                        <option value="">Select Status</option>
                                        @foreach ($availableStatuses as $status)
                                            <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                        @endforeach
                                    </select>
                                    @if (empty($availableStatuses))
                                        <div class="form-text text-muted">
                                            No available status transitions from current status.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn">
                            {{ empty($availableStatuses) ? '' : '' }}
                            <i class="bi bi-check-circle me-1"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                <a href="{{ route('admin.orders') }}" class="btn btn-outline-secondary me-2">
                    <i class="bi bi-arrow-left me-1"></i> Back to Orders
                </a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('css/order-detail.css') }}" rel="stylesheet">
@endpush
