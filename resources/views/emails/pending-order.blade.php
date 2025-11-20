@extends('emails.layouts.app')

@section('title', 'Pending Orders Report')
@section('container-class', 'wide')
@section('header-class', 'red')

@section('icon', '⚠️')
@section('header-title', 'Pending Orders Alert')
@section('header-subtitle', now()->format('F d, Y - H:i'))

@section('header')
    @include('emails.layouts.header')
@endsection

@section('content')
    <p>Hello Admin,</p>
    <p>This is your automated report for pending orders that require attention.</p>

    <div class="summary">
        <h2>📊 Summary Overview</h2>
        <div class="stat-row">
            <span class="stat-label">Total Pending Orders:</span>
            <span class="stat-value urgent">{{ $totalPending }} Orders</span>
        </div>
        <div class="stat-row">
            <span class="stat-label">Total Revenue Pending:</span>
            <span class="stat-value">${{ number_format($totalRevenue, 2) }}</span>
        </div>
        <div class="stat-row">
            <span class="stat-label">Report Generated:</span>
            <span class="stat-value muted">{{ now()->format('F d, Y - H:i') }}</span>
        </div>
    </div>

    @if ($totalPending > 5)
        <div class="alert-box">
            <p>
                <strong>⚠️ High Volume Alert:</strong> You have {{ $totalPending }} pending orders. Please process them as soon as possible to maintain customer satisfaction.
            </p>
        </div>
    @endif

    @if ($pendingOrder->count() > 0)
        <h2 class="red">📦 Pending Orders Details</h2>
        <table class="order-table">
            <thead>
                <tr>
                    <th>Order Code</th>
                    <th>Customer</th>
                    <th>Purchase Time</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendingOrder as $order)
                    <tr>
                        <td><strong>{{ $order->order_code }}</strong></td>
                        <td>{{ $order->user->username }}<br><small>{{ $order->user->email }}</small></td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $order->orderDetails->sum('quantity') }}</td>
                        <td>{{ number_format($order->total_amount, 0, ',', '.') }}$</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-center mt-30">
            <a href="{{ route('admin.orders') }}" class="button red">Manage Pending Orders</a>
        </div>
    @else
        <div class="success-box">
            <p>
                <strong>✓ All Clear!</strong><br>
                No pending orders at this time.
            </p>
        </div>
    @endif

    <p class="mt-30">This is an automated report to help you stay on top of order management.</p>

    <p>Best regards,<br><strong>Emart System</strong></p>
@endsection

@section('footer')
    @include('emails.layouts.footer')
@endsection

@section('footer-subtitle', 'Automated Order Management System')
