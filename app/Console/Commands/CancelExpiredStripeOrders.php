<?php

namespace App\Console\Commands;

use App\Constants\OrderStatus;
use App\Constants\PaymentStatus;
use App\Models\Order;
use App\Repositories\CartRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CancelExpiredStripeOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:cancel-expired-stripe-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel expired Stripe orders';

    protected $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        parent::__construct();
        $this->cartRepository = $cartRepository;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredOrders = Order::where('payment_method', 'stripe')
            ->where('payment_status', PaymentStatus::PENDING)
            ->where('order_status', OrderStatus::PENDING)
            ->where('created_at', '<=', now()->subMinutes(15))
            ->get();

        if ($expiredOrders->isEmpty()) {
            $this->info('No expired Stripe orders found.');
            return 0;
        }

        $cancelledCount = 0;

        foreach ($expiredOrders as $order) {
            try {
                DB::transaction(function () use ($order) {
                    $order->update([
                        'order_status' => OrderStatus::CANCELLED,
                        'payment_status' => PaymentStatus::CANCELLED,
                        'cancelled_at' => now(),
                        'cancel_reason' => 'Payment not completed within 15 minutes.',
                    ]);

                    foreach ($order->orderDetails as $detail) {
                        if ($detail->product_variant_id) {
                            $variant = $detail->productVariant;
                            if ($variant) {
                                $variant->increment('quantity_in_stock', $detail->quantity);
                            }
                        } else {
                            $detail->product->increment('quantity_in_stock', $detail->quantity);
                        }
                    }
                });

                $cancelledCount++;
                $this->info("Cancelled order ID: {$order->id}");
            } catch (\Throwable $e) {
                $this->error("Failed to cancel order ID: {$order->id}. Error: " . $e->getMessage());
            }
        }
        $this->info("Total cancelled orders: {$cancelledCount}");
        return 0;
    }
}
