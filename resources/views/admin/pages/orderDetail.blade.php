@extends('admin.layouts.app')

@section('title', 'Oder Detail - Emart Admin')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{ $order->order_code }}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Orders</a></li>
                <li class="breadcrumb-item active">{{ $order->order_code }}</li>
        </div>
        <div class="p-3">
            <div class="card p-3">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card-header">
                            <div>
                                Order Detail
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderDetails as $orderDetail)
                                        <tr>
                                            <td>{{ $orderDetail->snapshot_product_name }}</td>
                                            <td>{{ $orderDetail->unit_price }}</td>
                                            <td>{{ $orderDetail->quantity }}</td>
                                            <td>{{ $orderDetail->total_price }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="col-md-4">
                                <div class="card-body">
                                    <h5 class="card-title">Order Summary</h5>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subtotal:</span>
                                        <span>{{ $order->subtotal_amount }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Shipping:</span>
                                        <span>{{ $order->orderShipping->shipping_cost }}</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between fw-bold">
                                        <span>Total:</span>
                                        <span>{{ $order->total_amount }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card-header">
                            <div>
                                General Order Information
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Customer Name</td>
                                        <td>{{ $order->recipient_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Contact Info</td>
                                        <td>{{ $order->recipient_phone }}</td>
                                    </tr>
                                    <tr>
                                        <td>Address</td>
                                        <td>{{ $order->recipient_address }}</td>
                                    </tr>
                                    <tr>
                                        <td>Payment Method</td>
                                        <td>{{ $order->payment_method }}</td>
                                    </tr>
                                    <tr>
                                        <td>Order Status</td>
                                        <td>{{ $order->order_status }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('admin.orders') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
