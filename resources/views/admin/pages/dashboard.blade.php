@extends('admin.layouts.app')

@section('title', 'Dashboard - SB Admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
            <div>
                <h1 class="mb-0">Dashboard</h1>
                <p class="text-muted mb-0">Welcome back, Admin!</p>
            </div>
            <div>
                <span class="text-muted"><i class="fas fa-calendar"></i> {{ date('d M Y') }}</span>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card stats-card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 fw-medium">Total Users</p>
                                <h3 class="mb-0 fw-bold">{{ number_format($totalUsers) }}</h3>
                            </div>
                            <div class="stats-icon bg-primary bg-gradient text-white">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card stats-card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 fw-medium">Total Products</p>
                                <h3 class="mb-0 fw-bold">{{ number_format($totalProducts) }}</h3>
                                <small class="text-info"><i class="fas fa-box"></i> In stock</small>
                            </div>
                            <div class="stats-icon bg-warning bg-gradient text-white">
                                <i class="fas fa-box-open"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card stats-card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 fw-medium">Total Orders</p>
                                <h3 class="mb-0 fw-bold">{{ number_format($totalOrders) }}</h3>
                            </div>
                            <div class="stats-icon bg-success bg-gradient text-white">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card stats-card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 fw-medium">Total Revenue</p>
                                <h3 class="mb-0 fw-bold">{{ number_format($totalRevenue) }}$</h3>
                            </div>
                            <div class="stats-icon bg-danger bg-gradient text-white">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="row g-4">
            <div class="col-12">
                <div class="card chart-card">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Recent Orders</h5>
                            <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover recent-orders-table mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-4 py-3 border-0">Order ID</th>
                                        <th class="py-3 border-0">Customer</th>
                                        <th class="py-3 border-0">Date</th>
                                        <th class="py-3 border-0">Amount</th>
                                        <th class="py-3 border-0">Status</th>
                                        <th class="py-3 border-0 text-end pe-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="px-4 py-3 fw-medium">{{ $order->order_code }}</td>
                                            <td class="py-3">
                                                <div class="d-flex align-items-center">
                                                    <span>{{ $order->recipient_name }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3 text-muted">
                                                {{ date('d M Y', strtotime($order->created_at)) }}
                                            </td>
                                            <td class="py-3 fw-medium">
                                                {{ number_format($order->total_amount) }}$</td>
                                            <td class="py-3">
                                                <span
                                                    class="badge bg-{{ $order->order_status == 'pending' ? 'warning' : 'success' }} badge-status">{{ $order->order_status }}</span>
                                            </td>
                                            <td class="py-3 text-end pe-4">
                                                <a href="{{ route('admin.order-detail', $order->id) }}"
                                                    class="btn btn-sm btn-outline-primary">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
