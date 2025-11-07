<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Pending Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .order-table th,
        .order-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .order-table th {
            background-color: #f2f2f2;
        }

        .summary {
            background: #e7f3ff;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .urgent {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Pending order notification</h1>
            <p>Reporting time: <strong>{{ now()->format('d/m/Y H:i') }}</strong></p>
        </div>

        <div class="summary">
            <h2>General</h2>
            <p><strong>Total number of pending orders:</strong> <span class="urgent">{{ $totalPending }} Orders</span></p>
            <p><strong>Total Amount:</strong> {{ number_format($totalRevenue, 0, ',', '.') }} $</p>
        </div>

        @if ($pendingOrder->count() > 0)
            <h2>Orders</h2>
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

            <div style="margin-top: 30px; text-align: center;">
                <a href="{{ route('admin.orders') }}"
                    style="background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                    Order management
                </a>
            </div>
        @endif

        <footer style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #ddd; text-align: center;">
            <p>Auto Email From Emart Store</p>
        </footer>
    </div>
</body>

</html>
